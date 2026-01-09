<?php 
require_once __DIR__ . '/../Repository/CommandeRepository.php';


class ServiceCrud{
    private CommandeRepository $commande_repository;
    public function __construct()
    {
        $this->commande_repository = new CommandeRepository();
    }
    public function isDelete(int $id){
        return $this->commande_repository->AsDeeleted($id);
    }
}

?>