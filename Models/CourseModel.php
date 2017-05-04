<?php
    class CourseModel
    {
        public $CourseTitle;
        public $Description;

        public function SetCourseModel($courseTitle, $description)
        {
            $this -> CourseTitle = $courseTitle;
            $this -> Description = $description;
        }

        public function ValidateData()
        {
            if (strlen($this -> CourseTitle) === 0)
                return false;

            if (strlen($this -> Description) === 0)
                return false;

            return true;
        }
    }
?>