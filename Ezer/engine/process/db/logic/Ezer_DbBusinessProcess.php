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
 * Purpose:     Loads a business process from DB
 * @author Tan-Tan
 * @package Engine
 * @subpackage Process.Logic.DB
 */
class Ezer_DbBusinessProcess extends Ezer_BusinessProcess
{
	/**
	 * @var Ezer_IntBusinessProcess
	 */
	protected $dbImpl;
	
	public function __construct(Ezer_IntBusinessProcess $process)
	{
		$this->dbImpl = $process;
		parent::__construct($process->getId());
		$this->load();
		Ezer_DbStepContainerUtil::load($this, $process);
	}
	
	public function load()
	{
		$imports = $this->dbImpl->getImports();
		foreach($imports as $import)
			$this->addImport($import);
			
		$variables = $this->dbImpl->getVariables();
		foreach($variables as $variable)
			$this->addVariable($variable);
	}
	
	public function addVariable(Ezer_Variable $variable)
	{
		$this->variables[$variable->getName()] = $variable;
	}
	
	/**
	 * @param Ezer_Case $case
	 * @return Ezer_BusinessProcessInstance
	 */
	public function &createBusinessProcessInstance(Ezer_Case $case)
	{
		$dbInstance = $this->dbImpl->createBusinessProcessInstance($case);
		$ret = new Ezer_DbBusinessProcessInstance($dbInstance, $case, $this);
		return $ret;
	}
	
	public function &spawn(Ezer_ScopeInstance &$scope_instance)
	{
		$dbInstance = $this->dbImpl->spawn($scope_instance);
		$ret = new Ezer_DbScopeInstance($dbInstance, $scope_instance);
		return $ret;
	}
}

