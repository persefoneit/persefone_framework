<?
class persefone_fileUpload{

	var $estensioniSupportate;
	var $dimensioneMassima;
	var $directoryDestinazione;
	var $prefissoFile;
	var $messaggioErrore;
	var $nomeCampoFile;
	var $nomeFile;

	public function SettaEstensioni($valore){
		$this->estensioniSupportate=$valore;
	}

	public function SettaDimensioneMassima($valore){
		$this->dimensioneMassima=$valore;
	}

	public function SettaDirectory($valore){
		$this->directoryDestinazione=$valore;
	}

	public function SettaPrefisso($valore){
		$this->prefissoFile=$valore;
	}

	public function SettaNomeCampo($valore){
		$this->nomeCampoFile=$valore;
	}

	public function SettaNomeFile($valore){
		$this->nomeFile=$valore;
	}


	public function RitornaErrore(){
		return $this->messaggioErrore;
	}


	public function CaricaFile(){

		$esito=0;
		$errore=0;


		if(strlen($this->directoryDestinazione)<=0){
			$this->messaggioErrore = " Non hai impostato nessuna directory di destinazione ";
		    $errore=1;
		}else{
			if(!is_dir($this->directoryDestinazione)){
				$this->messaggioErrore = " La directory di destinazione non esiste ";
		   		$errore=1;
			}
		}

		if($this->dimensioneMassima>0 && ($_FILES[$this->nomeCampoFile]['size']/1000) > $this->dimensioneMassima && $errore==0){
			$this->messaggioErrore = " Dimensione massima del file $this->dimensioneMassima kb - dimensione attuale ".(round($_FILES[$this->nomeCampoFile]['size']/1000))." kb";
		    $errore=1;
		}


		if( strlen($this->estensioniSupportate)>0 && $errore==0){

			if( in_array( substr( $_FILES[$this->nomeCampoFile]["name"] , strrpos($_FILES[$this->nomeCampoFile]["name"], '.') + 1) ,explode(",",$this->estensioniSupportate))  ){
				$errore=0;
			}else{
				$this->messaggioErrore = "Estensione del file non supportata, sono supportate solo: ".$this->estensioniSupportate;
				$errore=1;
			}

		}

		if($errore==0){

			if(move_uploaded_file($_FILES[$this->nomeCampoFile]["tmp_name"], $this->directoryDestinazione."/".$this->prefissoFile.basename($_FILES[$this->nomeCampoFile]['name']))){

				$esito=1;

			}else{

				$this->messaggioErrore = "Si è verificato un errore ";

				switch ($_FILES[$this->nomeCampoFile]['error']) { 
					case 0:
						$this->messaggioErrore .= "";
						break;
		            case 1: 
		                $this->messaggioErrore .= "Il file inviato eccede le dimensioni specificate nel parametro upload_max_filesize di php.ini"; 
		                break; 
		            case 2: 
		                $this->messaggioErrore .= "Il file inviato eccede le dimensioni specificate nel parametro MAX_FILE_SIZE del form."; 
		                break; 
		            case 3: 
		                $this->messaggioErrore .= "Upload eseguito parzialmente"; 
		                break; 
		            case 4: 
		                $this->messaggioErrore .= "Nessun file è stato inviato"; 
		                break; 
		            case 6: 
		                $this->messaggioErrore .= "Mancanza della cartella temporanea. Inserito in PHP 4.3.10 e PHP 5.0.3"; 
		                break; 
		            case 7: 
		                $this->messaggioErrore .= "Errore di scrittura su disco. Inserito in PHP 5.1.0."; 
		                break; 
		            case 8: 
		                $this->messaggioErrore .= "Una estensione di PHP ha interotto il caricamento. PHP non fornisce un modo per capire quale estensione ha causato l'interruzione del caricamento; esaminare l'elenco delle estensioni caricate con phpinfo() può essere d'aiuto. Introdotto in PHP 5.2.0."; 
		                break; 
		            default: 
		                $this->messaggioErrore .= "Unknown upload error"; 
		                break; 
		        } 
		    }

	    }

	    return $esito; 
	}


	public function nameToSafe($name, $maxlen = 250){

		$noalpha = 'áéíóúàèìòùäëïöüÁÉÍÓÚÀÈÌÒÙÄËÏÖÜâêîôûÂÊÎÔÛñçÇ@';
		$alpha = 'aeiouaeiouaeiouAEIOUAEIOUAEIOUaeiouAEIOUncCa';
		$name = substr ($name, 0, $maxlen);
		$name = strtr ($name, $noalpha, $alpha); 
		return ereg_replace ('[^a-zA-Z0-9,._\+\()\-]', '_', $name);
		
	} 

}
?>
