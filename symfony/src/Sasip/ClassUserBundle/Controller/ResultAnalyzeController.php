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

    public function testAction() {
        $result = $this->overallPerformance('120339P');
        var_dump($result);
        return new \Symfony\Component\HttpFoundation\Response('');
    }

//    THis function is to provide individual mark of a student in a particular exam
    //this function returns MAX,AVG,Individual marks for a particular exam Id and student id;
    // result[avg]=avg of the exam
    // result[max]=max of the exam
    // result[individual]=individual of the exam

    public function getIndividualScore($examID, $studentID) {

        /*         * **********************individual syudent Section************************************ */

        $conn = $this->getDoctrine()->getManager()->getConnection();

        $query = 'SELECT * FROM enrolled_exam WHERE student_id= :studentID AND exam_id= :examID';
        $query1 = 'SELECT avg(marks) as avg,max(marks) as max FROM enrolled_exam group by(exam_id) having exam_id= :examID';
        $statement = $conn->prepare($query);
        $statement1 = $conn->prepare($query1);


        $statement->execute(array(
            'studentID' => $studentID,
            'examID' => $examID
        ));
        $statement1->execute(array(
            'examID' => $examID
        ));

        $result = $statement->fetchAll();
        $result1 = $statement1->fetchAll();

        if ($result && $result1) {
            $result = array(
                'individual' => $result[0]['marks'],
                'max' => $result1[0]['max'],
                'avg' => $result1[0]['avg']
            );

            return $result;
        } else {
            new Exception('Empty results');
        }
    }

//    this method will return data for exam-merks graph
//    returned array will look  like array[row number][relavant column name
    
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
        } else {
            throw new Exception('Empty result set');
        }
    }

    // average marks on a particular exam for individual performance graph when year of exam is given(year of the student face his exam)
    //average marks and max marks for a particular exam with exam ids will be returned.
    //two dimensional array will be returned.
//result[row number][avg]=avg mark of a particular year.

    public function getAvgMaxOfExam($yearOfExam) {

        $conn = $this->getDoctrine()->getManager()->getConnection();
        $query = "select avg(marks) as avg,max(marks) as max,exam_id from student "
                . "inner join enrolled_exam on student.id=enrolled_exam.student_id "
                . "group by(exam_id)"
                . " having year_of_exam= :yearOfExam";
        $stmt = $conn->prepare($query);

        $stmt->execute(array(
            'yearOfExam' => $yearOfExam
        ));

        $result = $stmt->fetchAll();

        if ($result) {
            return $result;
        } else {
            throw new Exception('Empty result set');
        }
    }

    /*     * ***********************************Teacher Section****************************************************** */

//    function will return avg,max and min respectively inside an array.

    public function overallExamPerformance($examId) {
        $conn = $this->getDoctrine()->getManager()->getConnection();
        $query = "SELECT avg(marks) as avg,max(marks) as max,min(marks) as min FROM enrolled_exam"
                . " group by (exam_id) having exam_id= :examId";

        $stmt = $conn->prepare($query);
        $stmt->execute(array(
            'examId' => $examId
        ));

        $result = $stmt->fetchAll();

        if ($result) {
            return $result;
        } else {
            throw new Exception('Empty result set');
        }
    }

    
//    function returns the avg,max and min respectively inside an array
//    results categorized according to the year of exam students face the exam        
    
    public function overallExamResults($yearOfExam) {
        $conn = $this->getDoctrine()->getManager()->getConnection();
        $query = "select avg(marks) as avg,max(marks) as max,min(marks) as min from student "
                . "inner join enrolled_exam on student.id=enrolled_exam.student_id "
                . "group by(exam_id)"
                . " having year_of_exam= :yearOfExam";

        $stmt = $conn->prepare($query);
        $stmt->execute(array(
            'yearOfExam' => $yearOfExam
        ));

        $result = $stmt->fetchAll();

        if ($result) {
            return $result;
        } else {
            throw new Exception('Empty result set');
        }
    }

}
