<?php
/**
 * Copyright (c) 2016 Ultra Community (http://www.ultracommunity.com)
 */

namespace  InvisibleReCaptcha\MchLib\Modules;

use InvisibleReCaptcha\MchLib\Plugin\MchBasePlugin;

//spl_autoload_register(array(__NAMESPACE__ . '\MchModulesController', 'autoLoadModulesClasses'), true, true);

class MchModulesController
{
	
	private static $arrRegisteredModules   = null;
	private static $arrAllAvailableModules = null;
	
	public static function initializeAvailableModules()
	{
		if(null !== self::$arrAllAvailableModules)
			return;
		
		self::$arrAllAvailableModules = (array)static::getAllAvailableModules();
	}
	
	
	protected static function getAllAvailableModules()
	{
		return array();
	}
	
	public static function getRegisteredModules()
	{
		if(null === self::$arrRegisteredModules)
			self::setRegisteredModules();
		
		return self::$arrRegisteredModules;
	}
	
	private static function setRegisteredModules()
	{
		if(null !== self::$arrRegisteredModules)
			return;
		
		self::initializeAvailableModules();
		self::$arrRegisteredModules = array();
		
		$engineDirPath = MchBasePlugin::getPluginDirectoryPath()  . '/engine/';
		
		foreach(self::$arrAllAvailableModules as $moduleName => &$arrModule)
		{
			self::$arrRegisteredModules[$moduleName] = array();
			
			foreach ($arrModule['classes'] as $className => $filePath)
			{
				$filePath = $engineDirPath . dirname($filePath) . DIRECTORY_SEPARATOR . basename($filePath);
				
				if(@file_exists($filePath)){
					
					if(empty(self::$arrRegisteredModules[$moduleName])){
						if(@file_exists(  $adapterFilePath = dirname($filePath) .  DIRECTORY_SEPARATOR . 'ModuleAdapter.php' ) ){
							include $adapterFilePath;
						}
					}
					
					self::$arrRegisteredModules[$moduleName][$className] = $filePath;
					continue;
				}
			}
			
			if(empty(self::$arrRegisteredModules[$moduleName]))
				unset(self::$arrRegisteredModules[$moduleName]);
			
			unset($arrModule['classes']);
		}
		
		
		\spl_autoload_register(function ($moduleClassName){
			
			foreach(MchModulesController::getRegisteredModules() as $arrModuleClasses)
			{
				if(!isset($arrModuleClasses[$moduleClassName]))
					continue;
				
				return require $arrModuleClasses[$moduleClassName];
			}
			
			return false;
			
			
			
		}, true, false);
		
		
	}
	
	
	public static function getModuleIdByName($moduleName)
	{
		return isset(self::$arrAllAvailableModules[$moduleName]['info']['ModuleId']) ? self::$arrAllAvailableModules[$moduleName]['info']['ModuleId'] : null;
	}
	
	public static function getModuleDisplayName($moduleIdORmoduleName)
	{
		$moduleName = ((false === filter_var($moduleIdORmoduleName, FILTER_VALIDATE_INT)) ? $moduleIdORmoduleName : self::getModuleNameById($moduleIdORmoduleName));
		
		return !empty(self::$arrAllAvailableModules[$moduleName]['info']['DisplayName']) ?  self::$arrAllAvailableModules[$moduleName]['info']['DisplayName'] : null;
		
	}
	
	
	public static function unRegisterModule($moduleName)
	{
		unset(self::$arrRegisteredModules[(string)$moduleName]);
	}
	
	
	public static function getModuleNameById($moduleId)
	{
		foreach(self::$arrAllAvailableModules as $moduleKey => $moduleValue)
		{
			if (isset($moduleValue['info']['ModuleId']) && $moduleValue['info']['ModuleId'] == $moduleId)
				return $moduleKey;
		}
		
		return null;
	}
	
	public static function getModuleDisplayNameByInstance(MchBaseModule $moduleInstance)
	{
		if(null === self::$arrRegisteredModules)
			self::setRegisteredModules();
		
		$moduleClass = get_class($moduleInstance);
		
		foreach(self::$arrRegisteredModules as $moduleKey => $arrModuleClasses)
		{
			if(!isset($arrModuleClasses[$moduleClass]))
				continue;
			
			return self::getModuleDisplayName($moduleKey);
		}
		
		return null;
	}
	
	public static function getModuleOptionDisplayText($moduleId, $optionId)
	{
		if(null === ($moduleAdminInstance = self::getAdminModuleInstance(self::getModuleNameById($moduleId))))
			return null;
		
		return $moduleAdminInstance->getOptionDisplayTextByOptionId($optionId);
	}
	
	public static function getModuleOptionId($moduleName, $optionName)
	{
		if(null === ($moduleAdminInstance = self::getAdminModuleInstance($moduleName)))
			return null;
		
		return $moduleAdminInstance->getOptionIdByOptionName($optionName);
	}
	
	public static function getModuleDirectoryPath($moduleName)
	{
		if(null === self::$arrRegisteredModules)
			self::setRegisteredModules();
		
		if(!isset(self::$arrRegisteredModules[$moduleName]) || !is_array(self::$arrRegisteredModules[$moduleName]))
			return null;
		
		return @dirname(reset(self::$arrRegisteredModules[$moduleName]));
	}
	
	/**
	 * @param string $moduleName
	 * @param int $moduleType
	 * @return \MchBaseModule | null
	 */
	private static function getModuleInstance($moduleName, $moduleType, $forceNewInstance)
	{
		if(null === self::$arrRegisteredModules)
			self::setRegisteredModules();
		
		if(!isset(self::$arrRegisteredModules[$moduleName]))
			return null;
		
		$arrModuleClasses = \array_keys(self::$arrRegisteredModules[$moduleName]);
		
		if(!isset($arrModuleClasses[1]))
			return null;
		
		for($i = 0; $i < 2; ++$i)
		{
			$isPublicClass = (\strpos($arrModuleClasses[$i], 'Public') !== false);
			
			if($isPublicClass && 2 === $moduleType)
			{

//				if(!\class_exists($arrModuleClasses[$i], false)) {
//					include self::$arrRegisteredModules[$moduleName][$arrModuleClasses[$i]];
//				}
				
				return $arrModuleClasses[$i]::getInstance($forceNewInstance);
				
			}
			
			if( !$isPublicClass && 1 === $moduleType )
				return $arrModuleClasses[$i]::getInstance($forceNewInstance);
			
		}
		
		return null;
		
	}
	
	/**
	 * @param string $moduleName Module name
	 *
	 * @return \InvisibleReCaptcha\MchLib\Modules\MchBaseAdminModule|null
	 */
	public static function getAdminModuleInstance($moduleName, $forceNewInstance = false)
	{
		return self::getModuleInstance($moduleName, 1, $forceNewInstance);
	}
	
	/**
	 * @param string $moduleName Module name
	 *
	 * @return \MchBasePublicModule|null
	 */
	public static function getPublicModuleInstance($moduleName, $forceNewInstance = false)
	{
		return self::getModuleInstance($moduleName, 2, $forceNewInstance);
	}
	
	/**
	 * @param $moduleName string Module name
	 *
	 * @return bool
	 */
	public static function isModuleRegistered($moduleName)
	{
		if(null === self::$arrRegisteredModules)
			self::setRegisteredModules();
		
		return 	isset(self::$arrRegisteredModules[$moduleName]);
	}

//	public static function autoLoadModulesClasses($moduleClassName)
//	{
//
//		if(null === self::$arrRegisteredModules)
//			self::setRegisteredModules();
//
//		foreach(self::$arrRegisteredModules as $arrModuleClasses)
//		{
//			if(!isset($arrModuleClasses[$moduleClassName]))
//				continue;
//
//			return include $arrModuleClasses[$moduleClassName];
//		}
//
//	}

}
