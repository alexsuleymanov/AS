<?php
namespace ASweb\SEO;

class DinamicRemarketing
{
	private static $conversion_id;
	private static $instance;
	
	private $types = ["home", "searchresults", "offerdetail", "conversionintent", "conversion", "other"];
	private $type;
	private $prods = [];
	private $prod_id;
	private $prod_price;
	
	const HOME = "home";
	const SEARCH = "searchresults";
	const PROD = "offerdetail";
	const ORDER = "conversionintent";
	const ORDER_MAKED = "conversion";
	const OTHER = "other";
		
	public function getInstance(string $conversion_id): DinamicRemarketing
	{
		if (static::$instance === NULL) {
			static::$instance = new static($conversion_id);
		}
		
		return static::$instance;
	}

	public function setType(string $type = '')
	{
		if (in_array($type, $this->types)) {
			$this->type = $type;
		} else {
			throw new \Exception("Wrong Dinamic Remarketing Type: ".$type);
		}		
	}
	
	public function setSingleProd(int $prod_id, float $price)
	{
		$this->prod_id = $prod_id;
		$this->prod_price = $price;
	}
	
	public function setProds(array $prods)
	{	
		$this->prods = $prods;
	}
		
	public function autoConfig(array $args, int $prod_id = 0, float $price = 0, array $prods = [])
	{
		if ($args[0] == "") { //Главная
			$this->type = static::HOME;
			$this->prod_id = 0;
			$this->prod_price = 0;
		} elseif ($args[0] == 'catalog' && $prod_id > 0) { //Товар
			$this->type = static::PROD;
			$this->prod_id = $prod_id;
			$this->prod_price = $price;
		} elseif ($args[0] == "search") { //Поиск
			$this->type = static::SEARCH;
			$this->prod_id = 0;
			$this->prod_price = 0;
		} elseif (($args[0] == "order" || $args[0] == "checkout") && ($args[1] == "completed" || $args[1] == "finish")) { //Заказ оформлен
			$this->type = static::ORDER_MAKED;
			if (!empty($prods)) {
				$this->prods = $prods;
			} else {
				$this->prod_id = $prod_id;
				$this->prod_price = $price;
			}
		} elseif (($args[0] == "order" && $args[1] != "completed" && $args[1] != "finish") || $args[0] == "cart") { //Корзина или заказ
			$this->type = static::ORDER;
			if (!empty($prods)) {
				$this->prods = $prods;
			} else {
				$this->prod_id = $prod_id;
				$this->prod_price = $price;
			}
		} else { //Другие
			$this->type = static::OTHER;
			$this->prod_id = 0;
			$this->prod_price = 0;
		}
	}	
		
	private function prodsString(): string
	{
		$string = "";

		if (!empty($this->prods)) {
			$prod_ids = [];
			
			foreach ($this->prods as $p) {
				$prod_ids[] = strval($p['id']);
			}
			
			$string = json_encode($prod_ids);
		} elseif($this->prod_id > 0) {
			$string = json_encode(strval($this->prod_id));
		} else {
			$string = "\"\"";
		}
		
		return $string;
	}
	
	private function amountString(): string
	{
		$string = "";
		if (!empty($this->prods)) {
			$prod_ids = [];
			
			foreach ($this->prods as $p) {
				$prod_ids[] = floatval($p['price']);
			}
			
			$string = json_encode($prod_ids);
		} elseif($this->prod_id > 0) {
			$string = json_encode(floatval($this->prod_price));
		} else {
			$string = "";
		}
		
		return $string;
	}
	
	public function draw()
	{
		echo "<script type=\"text/javascript\">
			var google_tag_params = {
				dynx_itemid: ".$this->prodsString().",
				dynx_pagetype: \"".$this->type."\",
				dynx_totalvalue: ".$this->amountString()."
			};
		</script>
		<script type=\"text/javascript\">
			/* <![CDATA[ */
			var google_conversion_id = ".$this->conversion_id.";
			var google_custom_params = window.google_tag_params;
			var google_remarketing_only = true;
			/* ]]> */
		</script>
		<script type=\"text/javascript\" src=\"//www.googleadservices.com/pagead/conversion.js\">
		</script>
		<noscript>	
			<div style=\"display:inline;\">
				<img height=\"1\" width=\"1\" style=\"border-style:none;\" alt=\"\" src=\"//googleads.g.doubleclick.net/pagead/viewthroughconversion/956491559/?guid=ON&amp;script=0\"/>
			</div>
		</noscript>";		
	}
	
	private function __construct(string $conversion_id)
    {
		$this->conversion_id = $conversion_id;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}