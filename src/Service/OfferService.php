<?php 
require_once __DIR__ . '/../Repository/OffreRepository.php';

class OfferService
{
    private OffreRepository $offre_repository;

    public function __construct()
    {
        $this->offre_repository = new OffreRepository();
    }
    public function add(): array
    {
        $row = $this->offre_repository->selectAll();
        return $row;
    }
    public function update(int $id, Offre $offre):void
    {
         $this->offre_repository->update( $id,$offre);
       
    }
    public function delete(int $id):void
    {
         $this->offre_repository->delete($id);
    }
    public function selectAllOffre(): array
    {
        $row = $this->offre_repository->selectAll();
        return $row;
    }






}