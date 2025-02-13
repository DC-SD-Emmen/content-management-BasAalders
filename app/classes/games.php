<?php
class GamesDb{
        private $titel;
        private $genre;
        private $platform;
        private $release_year;
        private $rating;
        private $image;
        private $description;
        //functions for setting and getting each different database collom 
        //get functions
        public function set_titel($titel){
            $this->titel = $titel;
        }

        public function set_genre($genre){
            $this->genre = $genre;
        }

        public function set_platform($platform){
            $this->platform = $platform;
        }

        public function set_release_year($release_year){
            $this->release_year = $release_year;
        }

        public function set_rating($rating){
            $this->rating = $rating;
        }

        public function set_image($image){
            $this->image = $image;
        }

        public function set_description($description){
            $this->description = $description;
        }

        public function get_titel(){
            return $this->titel;
        }

        public function get_genre(){
            return $this->genre;
        }
        //get functions
        public function get_platform(){
            return $this->platform;
        }   

        public function get_release_year(){
            return $this->release_year;
        }

        public function get_rating(){
            return $this->rating;
        }

        public function get_image(){
            return $this->image;
        }

        public function get_description(){
            return $this->description;
        }
    }
?>