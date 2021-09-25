<?php

# ADD ASSOCIATED FILES
require_once('./functions.php');

# Make Database Connection and add MeDoo
require_once('db_conn.php');

// Print DB info
dump_debug($database->info());

// SELECT ALL (*) Classes from our Classes table
	$classEditPost = $database->select("Classes",[
	//execute one inner joins
	"[><]Courses" => ["CourseID" => "ID"],
	"[><]Semesters" => ["SemesterID" => "ID"],
	// Remember to left join instructors to classes because not all instructors are in the people table
	"[>]ClassToInstructor" => ["ID" => "ClassID"],
	"[>]People" => ["InstructorID" => "ID"]
	],[
	"Classes.ID",
	"Classes.Description(classDescription)",
	"Courses.CourseNumber",
	"Courses.Name",
	"Classes.bMonday",
	"Classes.bTuesday",
	"Classes.bWednesday",
	"Classes.bThursday",
	"Classes.bFriday",
	"Classes.bSaturday",
	"Classes.bSunday",
	"Classes.MeetingTime",
	"Classes.Room",
	"People.ID(personID)",
	"People.FirstName",
	"People.LastName",
	"Courses.Prerequisites(CoursePrereqs)",
	"Classes.UniqueID", 
	"Classes.SyllabusURL", 
	"Classes.bWebBased", 
	"Classes.RoomMapURL", 
	"Classes.Notes", 
	"Classes.TopicDescription", 
	"Classes.Description(ClassDescription)",
	"Courses.Description(CourseDescription)",
	"Classes.bCancelled",
	"Classes.Year",
	"Classes.SemesterID",
	"Classes.ScheduleNotes",
	"Classes.Prerequisites(ClassPrereqs)",
	"Classes.Restrictions",
	"Classes.ClosingLimit",
	"Classes.AdminNotes",
	"Classes.bLive",
	"Classes.bHybrid",
	"Classes.bInPerson",
	"ClassToInstructor.InstructorID"
	],[
	"ORDER" => [
		// Order by column with sorting by custom order.
		"Classes.Year",
 
		// Order by column.
		"Courses.Name",
	]
	]);
	
	dump_debug($classEditPost);


?>