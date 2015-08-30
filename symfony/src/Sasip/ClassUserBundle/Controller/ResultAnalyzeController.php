<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sasip\ClassUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Acl\Exception\Exception;

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

    /*     * **********************************individual Performance*************************************************************** */

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

//    this method will return data for exam-marks graph
//    returned array will look  like array[row number][relavant column name]
//for individual student

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
//result[row number][max]=maximum mark of a particular year.


    public function getAvgMaxOfExam($yearOfExam) {

        $conn = $this->getDoctrine()->getManager()->getConnection();
        $query = "select avg(marks) as avg,max(marks) as max,exam_id,year_of_exam from student "
                . " inner join enrolled_exam on student.id=enrolled_exam.student_id "
                . " group by(exam_id)"
                . " having year_of_exam = :yearOfExam";
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

//    this function is to render viewAllResult section
//    require examId to output data
//    send examIds for rendering template

    public function individualResultAction($examId) {
        $student = $this->container->get('security.context')->getToken()->getUser();
        $studentId = $student->getUsername();
        $examIds = $this->overallPerformance($studentId);

        $result = $this->getIndividualScore($examId, $studentId);
        return $this->render("ClassUserBundle:Profiles/Student:viewAllResult.html.twig", array(
                    'result' => $result,
                    'examId' => $examIds
        ));
    }

    //this function render the twig of reslt analysis with the 
    // result Student and rsultClass separately

    public function resultAnalysisAction() {

        $person = $this->container->get('security.context')->getToken()->getUser();
        $studentId = $person->getUsername();

        $student = $this->getDoctrine()->getManager()->getRepository('ClassUserBundle:Student')->find($studentId);
        $yearOfExam = $student->getYearOfExam();
        $resultStudent = $this->overallPerformance($studentId);
        $resultClass = $this->getAvgMaxOfExam($yearOfExam);

        for ($key = 0; $key < sizeof($resultStudent); $key++) {
            $avg[$key] = $resultClass[$key]['avg'];
            $individual[$key] = $resultStudent[$key]['marks'];
            $max[$key] = $resultClass[$key]['max'];
            $examID[$key] = $resultStudent[$key]['exam_id'];
        }

        return new JsonResponse(array(
            'avg' => $avg,
            'individual' => $individual,
            'max' => $max,
            'examId' => $examID
        ));
    }

    public function resultAnalysisTemplateAction() {
        return $this->render('ClassUserBundle:Profiles/Student:resultAnalysis.html.twig');
    }

    /*     * **************************************end of individual performance********************************************************** */


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

    public function BruteExamPerformance($examId) {
        $conn = $this->getDoctrine()->getManager()->getConnection();
        $query = "SELECT concat(first_name,' ',last_name) as name, student_id, marks FROM enrolled_exam"
                . " inner join student on student.id = enrolled_exam.student_id"
                . " where exam_id= :examId";

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

    //get the avg of all students
    public function getAvgOfStudent() {
        $query = "SELECT avg(marks) as avg,student_id FROM enrolled_exam group by(student_id)";
        $conn = $this->getDoctrine()->getConnection();
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    }

//    function returns the avg,max and min respectively inside an array
//    results categorized according to the year of exam, students face the exam        

    public function overallExamResults($yearOfExam) {
        $conn = $this->getDoctrine()->getManager()->getConnection();
        $query = "select avg(marks) as avg,max(marks) as max,min(marks) as min, exam_id,year_of_exam from student " .
                " inner join enrolled_exam on student.id=enrolled_exam.student_id "
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

    /*     * ***********************************teacher result Analysis Actions***************************************** */

//when year of exam is entered all the respective exams will be returned with thier analysis

    public function teacherOverallResultAction(Request $request) {
        $yearOfExam = $request->get('year');
        $result = $this->overallExamResults($yearOfExam);
        $data_avg = null;
        $data_max = null;
        $data_min = null;
        $data_examId = null;

        for ($i = 0; $i < sizeof($result); $i++) {
            $data_avg[$i] = $result[$i]['avg'];
            $data_max[$i] = $result[$i]['max'];
            $data_min[$i] = $result[$i]['min'];
            $data_examId[$i] = $result[$i]['exam_id'];
        }

        return new JsonResponse(array(
            'data_avg' => $data_avg,
            'data_max' => $data_max,
            'data_min' => $data_min,
            'data_examId' => $data_examId
        ));
    }

// when an exam id is entered particular analyssis will be returned
    public function teacherOverallPerformanceAction(Request $request) {
        $examId = $request->get('id');
        $result = $this->overallExamPerformance($examId);
        return new JsonResponse($result);
    }

    //all the marks will be returned when examId is entered
    public function teacherBruteExamResultAction(Request $request) {
        $examId = $request->get('id');
        $result = $this->BruteExamPerformance($examId);
        $avg = $this->getAvgOfStudent();

        return new JsonResponse(array(
            'indiResult' => $result,
            'avg' => $avg
        ));
    }

    public function teacherBruteExamResultRenderAction() {
        $exam_id = $this->returnExamIDS();
        return $this->render('ClassUserBundle:Profiles/Teacher:recentResults.html.twig', array(
                    'exams' => $exam_id,
        ));
    }

    public function returnExamIDS() {
        $conn = $this->getDoctrine()->getConnection();
        $query_1 = "SELECT id FROM exam";
        $stmt_1 = $conn->prepare($query_1);
        $stmt_1->execute();
        $exam_id = $stmt_1->fetchAll();
        return $exam_id;
    }

    public function renderTeacherExamResultAction() {

        $query = "SELECT year_of_exam FROM student GROUP BY (year_of_exam)";

        $conn = $this->getDoctrine()->getConnection();

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $years = $stmt->fetchAll();
        $exam_id = $this->returnExamIDS();
        return $this->render('ClassUserBundle:Profiles/Teacher:viewAllResults.html.twig', array(
                    'exams' => $exam_id,
                    'acaYears' => $years
        ));
    }

    /*     * ***********************************teacher result Analysis Actions End***************************************** */




    /*     * ************************************utility Section************************************************* */

//    this function provides twig component for results when examId is given
//    when java script request being made
    public function getResultIndividualComponentAction(Request $request) {
        $student = $this->container->get('security.context')->getToken()->getUser();
        $studentId = $student->getUsername();
        $examId = $request->get('examId');
        $result = $this->getIndividualScore($examId, $studentId);

        return $this->render("ClassUserBundle:Profiles/Student/Utility:individualScore.html.twig", array(
                    'result' => $result
        ));
    }

    /*     * ********************************************************************************************************** */
}
