<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sasip\ClassUserBundle\Tests\Controller;

use Sasip\ClassUserBundle\Controller\ResultAnalyzeController;

/**
 * Description of ResultAnalyzeControllerTest
 *
 * @author Flash
 */
class ResultAnalyzeControllerTest extends \PHPUnit_Framework_TestCase {

    public function testGetIndividualScore(){
        $testMod = new ResultAnalyzeController();
        
        $result=$testMod->getIndividualScore('201101', '120339P');        
        $this->assertEquals(85,$result);
        
    }

    

}
