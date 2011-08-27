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
 * Purpose:     Loads a sequense from DB
 * @author Tan-Tan
 * @package Engine
 * @subpackage Process.Logic.DB
 */
class Ezer_DbAssignStep extends Ezer_AssignStep
{
	/**
	 * @var Ezer_IntAssignStep
	 */
	protected $dbImpl;
	
	public function __construct(Ezer_IntAssignStep $assignStep)
	{
		$this->dbImpl = $assignStep;
		parent::__construct($assignStep->getId());
		$this->load($assignStep);
	}
	
	public function load(Ezer_IntAssignStep $assignStep)
	{
		$this->setName($assignStep->getName());
		$this->setCopies($assignStep->getCopies());
	}
	
	public function &createInstance(Ezer_ScopeInstance &$scope_instance)
	{
		$dbInstance = $this->dbImpl->createInstance($scope_instance);
		$ret = new Ezer_DbAssignStepInstance($dbInstance, $scope_instance, $this);
		return $ret;
	}
}

