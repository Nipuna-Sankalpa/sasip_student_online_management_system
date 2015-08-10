<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sasip\ClassUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of ResultAnalyzeController
 *
 * @author Flash
 */
class ResultAnalyzeController extends Controller {

//    THis function is to provide individual mark of a student in a particular exam
    public function getIndividualScore($examID, $studentID) {
        $conn = $this->getDoctrine()->getManager()->getConnection();
        $query = "SELECT FROM enrolled_exam WHERE student_id= :studentID AND exam_id= :examID";
        $statement = $conn->prepare($query);

        $statement->execute(array(
            'studentID' => $studentID,
            'examID' => $examID
        ));

        $result = $statement->fetchAll();

        if ($result) {
            return $result[0]['marks'];
        } else {
            new Exception('Empty results');
        }
    }

//    this method will return data for exam-merks graph
//    returned array will look  like array[row number][relavant column name]
    public function overallPerformance($studentID) {
        $conn = $this->getDoctrine()->getManager()->getConnection();
        $query = "SELECT marks,exam_id FROM enrolled_exam WHERE student_id= :studentID";

        $stmt = $conn->prepare($query);
        $stmt->execute(array(
            'studentID' => $studentID
        ));

        $result = $stmt->fetchAll();

        if ($result) {
            return $result;
        }  else {
            throw new Exception('Empty result set');
        }
    }

}
