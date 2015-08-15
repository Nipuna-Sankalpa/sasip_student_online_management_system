<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sasip\ClassUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Acl\Exception\Exception;

/**
 * Description of AttendanceAnalyzerController
 *
 * @author Flash
 */
class AttendanceAnalyzerController extends Controller {

//    this function returns attendance list of a specified student
//    returns date of attendance,time of attendance, attended class,subject of the class and the teacher

    public function individualAttendance($studentId) {
        $conn = $this->getDoctrine()->getManager()->getConnection();
        $query = "SELECT student_attendance.Date,student_attendance.time,class.id,class.subject,CONCAT(teacher.firstName,' ',teacher.lastName) as name FROM student_attendance"
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

//    function will return date(year and month) number of students attended
//    result will be given according to the classId

    public function attendanceAnalysis($classId) {
        $query = "select concat(year(Date),' ',month(date)) as year, count(student_id) as studentCount"
                . "from student_attendance"
                . "group by Month(date),class_id"
                . "having class_id= :classId";
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
                . "GROUP BY (class_id)"
                . "having class_id= :classId";

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

//    function will return total number of student who came for an particular exam

    public function examAttendance($examId) {
        $query = "SELECT COUNT(student_id) as studentCount FROM student_attendance"
                . "GROUP BY (class_id)"
                . "having class_id= :classId%";

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

//    this function render the twig of individual attendance with attendance details
    public function studentAttendanceAction() {
        $student = $this->container->get('security.context')->getToken()->getUser();
        $id = $student->getUsername();
        
        $result = $this->individualAttendance('120339P');

        return $this->render("ClassUserBundle:Profiles/Student:Attendance.html.twig", array(
                    'attendance' => $result
        ));
    }

}
