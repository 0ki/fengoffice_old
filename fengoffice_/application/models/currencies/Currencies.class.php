<?php 

	class Currencies extends BaseCurrencies {
		
		static function getCurrenciesInfo() {
			$currencies = self::findAll(array('order' => 'is_default DESC'));
			$info = array();
			foreach ($currencies as $c) $info[] = $c->getArrayInfo();
			
			return $info;
		}
		
		static function getDefaultCurrencyInfo() {
			$infos = self::getCurrenciesInfo();
			return array_var($infos, 0, array());
		}
		
		private $cache = null;
		function getCurrency($id) {
			if (!isset($this) || !$this instanceof Currencies) {
				return Currencies::instance()->getCurrency($id);
			}
			
			if ($this->cache == null) {
				$all = Currencies::findAll();
				$this->cache = array();
				foreach ($all as $obj) {
					$this->cache[$obj->getId()] = $obj;
				}
			}
			
			return array_var($this->cache, $id);
		}
		
	}
