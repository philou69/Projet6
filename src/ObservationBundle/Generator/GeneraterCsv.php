<?php


namespace ObservationBundle\Generator;


use Doctrine\ORM\EntityManager;
use ObservationBundle\Entity\Location;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Validator\Constraints\DateTime;

class GeneraterCsv
{
    protected $em;
    protected $path;
    public function __construct(EntityManager $em, $csv_path)
    {
        $this->em = $em;
        $this->path = realpath($csv_path);
    }

    public function GetCSV()
    {
        $listEntities = ['Bird', 'Location', 'Observation', 'Fiche'];
        $delimiteur = ";";
        foreach ($listEntities as $entity){
            // Recuperation de toutes les lignes de l'entité
            $list = $this->em->getRepository('ObservationBundle:' . $entity)->findForCSV();
            // Création du chemin du fichier
            $cheminFile = $this->path .'/'. strtolower($entity) . '.csv';
            // ouverture du fichier
            $fichierCSV = fopen($cheminFile, 'w+');
            // Correction des problèmes d'affichage de caractères spéciaux sous Excel
            fprintf($fichierCSV, chr(0xEF), chr(0xBB),chr(0xBF));

            // Remplisage du fichier avec le contenu de l'entité
            foreach ($list as $ligne){
                foreach ($ligne as $key => $value){
                    if($ligne[$key] instanceof \DateTime){
                        $ligne[$key] = $value->format('Y-m-d H:i:s');
                    }
                }
                fputcsv($fichierCSV, $ligne, $delimiteur);
            }
            fclose($fichierCSV);
        }
        $locations = $this->em->getRepository("ObservationBundle:Location")->findAll();
        $bird_locations = [];
        foreach ($locations as $location)
        {
            foreach ($location->getBirds() as $bird){
                $bird_locations[] = [$bird->getId(), $location->getId()];
            }
        }
        $cheminFile = $this->path .'/bird_location.csv';
        // ouverture du fichier
        $fichierCSV = fopen($cheminFile, 'w+');
        // Correction des problèmes d'affichage de caractères spéciaux sous Excel
        fprintf($fichierCSV, chr(0xEF), chr(0xBB),chr(0xBF));

        // Remplisage du fichier avec le contenu de l'entité
        foreach ($bird_locations as $birdLocation){
            fputcsv($fichierCSV, $birdLocation, $delimiteur);
        }
        fclose($fichierCSV);

        $this->createZip();

    }

    public function createZip(){
            if($dir = opendir($this->path)){
                // On crée le chemin de fin
                $pathZip = $this->path . '/ZIP/export-nao.zip';
                $oZip = new \ZipArchive();
                $oZip->open($pathZip, \ZIPARCHIVE::OVERWRITE);
                $finder = new Finder();
                // On boucle uniquement sur les fichier .csv

                foreach ($finder->in($this->path)->name('*.csv') as $file){
                    $oZip->addFile($file->getPathName(), $file->getFileName());
                }
                // On ferme l'archive
                return $oZip->close();
            }

    }
}