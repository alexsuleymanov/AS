<?php
namespace ASweb\Distrib;
	
abstract class Message 
{
	protected $subject;
	protected $body;
	protected $files;
	protected $type;
	protected $params;
	
	public function __construct(array $params = array())
	{
		$this->subject = $params['subj'];
		$this->files = $params['files'];
		$template = $params['template'];
		
		unset($params['subj']);
		unset($params['files']);
		unset($params['template']);
		
		$this->params = $params;
		
		$params['cont'] = $this->getCont(); // Абстрактный метод. Паттерн фабричный метод
		
		$this->body = $this->messageFromTemplate($template, $params);
	}
	
	abstract protected function getCont();
	
	public function getSubject(): string
	{
		return $this->subject;
	}
	
	public function getBody(): string
	{
		return $this->body;
	}
	
	public function getFiles(): array
	{
		return $this->files;
	}

	public function getType(): string
	{
		return $this->type;
	}
	
	protected function messageFromTemplate(string $template, array $params): string
	{
		$labels = $params['labels'];
		$sett = $params['sett'];
		
		$rep = array();
		preg_match_all("/{([\$\[\]\'\w\_\-\d]+)}/", $template, $m);

		foreach ($m[1] as $k => $v){
			if ($v[0] == '$'){
				if (strstr($v, "[")){
					$vv = substr($v, 1, strpos($v, "[")-1);
					preg_match("/\[[\'\"]([^\'\"]+)[\'\"]\]/", $v, $m);
					$rep["{".$v."}"] = ${$vv}[$m[1]];
				}else{
					$rep["{".$v."}"] = ${'v'};
				}
			}
			else
				$rep["{".$v."}"] = $params[$v];
		}
			
		return str_replace(array_keys($rep), array_values($rep), $template);
	}
	
}
