Questa è una raccolta di classi php usate nella ns azienda

class.fileupload.php
===================

Permette di caricare un file in una cartella specifica limitandone dimensione, estensioni.
Esempio di utilizzo:

$file= new persefone_fileUpload();

$file->SettaDirectory("uploads/test");

$file->SettaNomeCampo("nome");

$file->SettaEstensioni("jpg,png,bmp");

$file->SettaNomeFile("nuovonome");

$file->SettaDimensioneMassima(290); //in kb

$file->SettaPrefisso("xxxxxxxx");

if($file->CaricaFile()==1)echo "ok, caricato";
else echo $file->RitornaErrore();

