<?php
	class dataTemplate{
		public $key = "";
		public $data = null;
		public $timemade = null;

		public function __construct($kdata,$moredata){
			$this->key = $kdata;
			$this->data = $moredata;

			$datedata = Date('d-m-y h:i:s');
			$this->timemade = $datedata;
		}
	}

	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$reqdata = file_get_contents("php://input");
		$parsed = json_decode($reqdata); 
		$datafile = "thedata/accessdata.json";

		// make a class blueprint for the upload object with a key and content

		// echo "uploading data: \n\n\t $reqdata";

		// ready the file
		$logfile = fopen($datafile, "w");

		// get data
		$gottendata = file_exists($datafile) ? file_get_contents($datafile) : "[]";
		$gottendata = $gottendata != "" ? $gottendata : "[]";

		$thekey = substr((str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890')),0,4);

		$newrecord = new dataTemplate($thekey,$parsed->inv_data);
		$curdata = json_decode($gottendata);

		array_push($curdata, $newrecord);

		// echo $curdata;
		$towrite = json_encode($curdata);

		fwrite($logfile, $towrite);
		fclose($logfile);

		echo "data added successfully|$thekey";
	} else {
		echo "invalid request method";
	}
?>