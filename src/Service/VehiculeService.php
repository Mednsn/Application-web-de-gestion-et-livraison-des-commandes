<?php 
require_once __DIR__ . '/../Repository/Vehicule_repository.php';

class vehiculeService
{
    private Vehicule_repository $vehicule_repository;

    public function __construct()
    {
        $this->vehicule_repository = new Vehicule_repository();
    }
    public function add(Vehicule $vehicule)
    {
        return $this->vehicule_repository->add($vehicule);
        
    }
    public function selectVehicleByNmae( string $name)
    {
         return $this->vehicule_repository->selectVehiculeByNmae($name);
       
    }
    
    // public function delete(int $id):void
    // {
    //      $this->vehicule_repository->delete($id);
    // }






}