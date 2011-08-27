<?php

/**
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * For questions, help, comments, discussion, etc., please send
 * e-mail to johnathan.kanarek@gmail.com
 */


/**
 * Purpose:     Load business process definitions from xml file
 * @author Tan-Tan
 * @package Engine
 * @subpackage Process.Logic.XML
 */
class Ezer_XmlLogicPersistance implements Ezer_ProcessLogicPersistance
{
	protected $processes = array();
	protected $instance_path;
	
	public function __construct($logic_path, $instance_path)
	{
		$this->instance_path = $instance_path;
		$this->parseDir($logic_path);
	}

	private function parseDir($path)
	{
		$dir = dir($path);
		if(!$dir)
			return;
		
		while (false !== ($entry = $dir->read())) 
		{
			if($entry == '.' || $entry == '..' || $entry == '.svn')
				continue;

			if(is_dir("$path/$entry"))
				$this->parseDir("$path/$entry");
			
			$this->parseFile("$path/$entry");
		}
		$dir->close();
	}
	
	private function parseFile($file)
	{
		$doc = new DOMDocument();
		$loaded = $doc->load($file);

		if(!$loaded)
		{
			throw new ConfigNotLoadedException($configFilePath);
			return;
		}
		
		$process = new Ezer_XmlBusinessProcess($doc->documentElement, $this->instance_path);
		$this->processes[$process->getName()] = $process;
	}
	
	public function getProcesses()
	{
		return $this->processes;
	}
}

