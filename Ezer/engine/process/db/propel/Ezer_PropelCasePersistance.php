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
 * Purpose:     Load case definitions from xml file
 * @author Tan-Tan
 * @package Engine
 * @subpackage Process.Case.DB
 */
class Ezer_PropelCasePersistance implements Ezer_ProcessCasePersistance
{
	private $cases = array();
	private $path = array();
	
	public function __construct($config)
	{
		Propel::setConfiguration($config);
		Propel::initialize();
	}
	
	private function loadCases()
	{
		$dbCases = Ezer_PropelCasePeer::retrieveReadyToStart();
		foreach($dbCases as $dbCase)
		{
			$dbCase->incrementExcutionIndex();
			if($dbCase->getExcutionRepeats() && $dbCase->getCurrentExcutionIndex() >= $dbCase->getExcutionRepeats())
			{
				$dbCase->delete();
			}
			else
			{
				$nextExcution = time() + $dbCase->getExcutionInterval();
				$dbCase->setNextExcutionTime($nextExcution);
				$dbCase->save();
			}
			
			$this->cases[] = $this->loadCase(clone $dbCase);
		}
	}
	
	private function addVariablePart(array &$variable, $part)
	{
		if(!($part instanceof Ezer_Config))
		{
			$variable[] = $part;
			return;
		}
		
		$value = null;
		
		if(isset($part['value']))
			$value = $part['value'];
		
		if(isset($part['part']))
		{
			$value = array();
			$this->addVariablePart($value, $part['part']);
		}
	
		if($part->type == Ezer_Config::ARRAY_TYPE)
		{
			$value = array();
			$arr = $part->getArrayCopy();
			foreach($arr as $index => $part_part)
			{
				if(is_numeric($index))
					$this->addVariablePart($value, $part_part);
			}
		}
		
		if(isset($part['name']))
			$variable[$part['name']] = $value;
		else
			$variable[] = $value;
	}
	
	private function loadCase(Ezer_PropelCase $dbCase)
	{
		$case = new Ezer_Case($dbCase->getId(), $dbCase->getProcessId());
		$case->setVariables($dbCase->getVariables());
			
		return $case;
	}
	
	public function getCases()
	{
		$this->cases = array();
		$this->loadCases();
		return $this->cases;
	}
}

