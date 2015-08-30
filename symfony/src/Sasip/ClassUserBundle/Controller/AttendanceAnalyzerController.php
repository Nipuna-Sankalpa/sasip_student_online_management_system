<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sasip\ClassUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Acl\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Description of AttendanceAnalyzerController
 *
 * @author Flash
 */
class AttendanceAnalyzerController extends Controller {

//    this function returns attendance list of a specified student
//    returns date of attendance,time of attendance, attended class,subject of the class and the teacher

    public function individualAttendanceClass($studentId) {
        $conn = $this->getDoctrine()->getManager()->getConnection();
        $query = "SELECT student_attendance.Date,student_attendance.time,class.id,class.subject,CONCAT(teacher.first_name,' ',teacher.last_name) as name FROM student_attendance"
                . " inner join class"
                . " on student_attendance.class_id=class.id"
                . " inner join teacher"
                . " on class.teacher_id=teacher.id"
                . " where student_attendance.student_id= :studentId"
                . " ORDER BY student_attendance.Date DESC";

        $stmt = $conn->prepare($query);
        $stmt->execute(array(
            'studentId' => $studentId
        ));

        $result = $stmt->fetchAll();
        if ($result) {
            return $result;
        } else {
            return $result = null;
//            throw new Exception('Empty result set');
        }
    }

    public function individualAttendanceExam($studentId) {
        $conn = $this->getDoctrine()->getManager()->getConnection();
        $query = "select student_attendance.Date,student_attendance.time,class_id,concat(first_name,' ',last_name) as teacher"
                . " from student_attendance inner join "
                . " exam on exam.id=student_attendance.class_id "
                . " inner join teacher on teacher.id=exam.teacher_id "
                . " where student_attendance.student_id= :studentId";

        $stmt = $conn->prepare($query);
        $stmt->execute(array(
            'studentId' => $studentId
        ));

        $result = $stmt->fetchAll();
        if ($result) {
            return $result;
        } else {
            return $result = null;
//            throw new Exception('Empty result set');
        }
    }

//    function will return date(year and month) number of students attended
//    result will be given according to the classId

    public function attendanceAnalysis($classId) {
        $query = "select concat(year(Date),' ',month(Date)) as year, count(student_id) as studentCount"
                . " from student_attendance"
                . " group by Month(Date),year(Date),class_id"
                . " having class_id= :classId";
        $conn = $this->getDoctrine()->getManager()->getConnection();
        $stmt = $conn->prepare($query);
        $stmt->execute(array(
            'classId' => $classId
        ));

        $result = $stmt->fetchAll();
        if ($result) {
            return $result;
        } else {
            throw new Exception('Empty result set');
        }
    }

//    function will return all the active registered students

    public function registeredStudents($classId) {
        $query = "SELECT COUNT(student_id) as studentCount FROM student_register"
                . " GROUP BY (class_id)"
                . " having class_id= :classId";

        $conn = $this->getDoctrine()->getManager()->getConnection();
        $stmt = $conn->prepare($query);
        $stmt->execute(array(
            'classId' => $classId
        ));

        $result = $stmt->fetchAll();
        if ($result) {
            return $result;
        } else {
            throw new Exception('Empty result set');
        }
    }

//    function will return total number of students who came for an particular exam

    public function examAttendance($examId) {
        $query = "SELECT COUNT(student_id) as studentCount FROM student_attendance"
                . " GROUP BY (class_id)"
                . " having class_id= :classId";

        $conn = $this->getDoctrine()->getManager()->getConnection();
        $stmt = $conn->prepare($query);
        $stmt->execute(array(
            'classId' => $examId
        ));

        $result = $stmt->fetchAll();
        if ($result) {
            return $result;
        } else {
            throw new Exception('Empty result set');
        }
    }

    //this function will return total number of students who enrolled to a particular exam
    public function totalEnrolledExam($examId) {
        $query = "SELECT COUNT(student_id) as studentCount FROM enrolled_exam "
                . " GROUP BY (exam_id) "
                . " having exam_id= :exam_id";

        $conn = $this->getDoctrine()->getManager()->getConnection();
        $stmt = $conn->prepare($query);
        $stmt->execute(array(
            'exam_id' => $examId
        ));

        $result = $stmt->fetchAll();
        if ($result) {
            return $result;
        } else {
            throw new Exception('Empty result set');
        }
    }

    //this function will return number of students study under a particular year of exam
    //eg- how many students learn who face thier a/l in 2011??
    //the fucntion wil respond to the exam id and this method was created to find which is mentioned above when exam id is given

    public function totlaStudentStudy($examId) {
        $yearOfexam = null;
        $query = "SELECT student_id FROM enrolled_exam where exam_id= :exam_id limit 1";
        $conn = $this->getDoctrine()->getManager()->getConnection();
        $stmt = $conn->prepare($query);
        $stmt->execute(array(
            'exam_id' => $examId
        ));
        $result = $stmt->fetchAll();
        if ($result) {
            $studentId = $result[0]['student_id'];
            $query = "SELECT year_of_exam FROM student where id= '$studentId' ";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll();

            if ($result) {
                $yearOfexam = $result[0]['year_of_exam'];
            }
        }

        if ($yearOfexam) {
            $query = "SELECT COUNT(id) as studentCount FROM student"
                    . " GROUP BY (year_of_exam)"
                    . " having year_of_exam= '$yearOfexam'";

            $stmt = $conn->prepare($query);
            $stmt->execute();

            $result = $stmt->fetchAll();
            if ($result) {
                return $result;
            } else {
                throw new Exception('Empty result set');
            }
        } else {
            throw new Exception('Query Error');
        }
    }

//  this function render the twig of individual class attendance with attendance details
    public function studentClassAttendanceAction() {
        $student = $this->container->get('security.context')->getToken()->getUser();
        $id = $student->getUsername();

        $result = $this->individualAttendanceClass($id);

        return $this->render("ClassUserBundle:Profiles/Student:AttendanceClass.html.twig", array(
                    'attendance' => $result
        ));
    }

//  this function render the twig of individual exam attendance with attendance details
    public function studentAttendanceExamAction() {
        $student = $this->container->get('security.context')->getToken()->getUser();
        $id = $student->getUsername();

        $result = $this->individualAttendanceExam($id);

        return $this->render("ClassUserBundle:Profiles/Student:AttendanceExam.html.twig", array(
                    'attendance' => $result
        ));
    }

    /*     * *********attendance analysis according to the teacher's perspective**** */

    //this method will return the values(data sets for) attendance Analysis (teachers perspective) 
    public function teacherclassAttendanceAction(Request $request) {
        $classId = $request->get('id');
        $attendance = $this->attendanceAnalysis($classId);
        $totalRegStudents = $this->registeredStudents($classId);
        $dataSet_1 = null;
        $dataSet_2 = null;

// since each student should be present at 4 times per month there for 100 shold be devided by 4.
        for ($i = 0; $i < sizeof($attendance); $i++) {
            $dataSet_1[$i] = ($attendance[$i]['studentCount'] / $totalRegStudents[0]['studentCount']) * 25;
            $dataSet_2[$i] = $attendance[$i]['year'];
        }

        return new JsonResponse(array(
            'dataSet_1' => $dataSet_1,
            'dataSet_2' => $dataSet_2
        ));
    }

    public function teacherExamAttendanceAction(Request $request) {
        $examId = $request->get('id');
        $examTotCount = $this->examAttendance($examId);
        $examTotEnrolled = $this->totalEnrolledExam($examId);
        $studentTotal = $this->totlaStudentStudy($examId); //total number of students registered under a partiicular year of exam

        return new JsonResponse(array(
            'examTotCount' => $examTotCount,
            'examTotEnrolled' => $examTotEnrolled,
            'studentTotal' => $studentTotal
        ));
    }

    public function renderClassAttendanceAction() {
        $query = "SELECT id FROM class";

        $conn = $this->getDoctrine()->getManager()->getConnection();
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $this->render('ClassUserBundle:Profiles/Teacher:ClassAttendance.html.twig', array(
                    'classes' => $result
        ));
    }

    public function renderExamAttendanceAction() {
        $query = "SELECT id FROM exam";

        $conn = $this->getDoctrine()->getManager()->getConnection();
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $this->render('ClassUserBundle:Profiles/Teacher:ExamAttendance.html.twig', array(
                    'examId' => $result
        ));
    }

    /*     * *********************************************************************** */
}
