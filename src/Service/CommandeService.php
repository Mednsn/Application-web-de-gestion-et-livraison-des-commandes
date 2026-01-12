<?php
require_once __DIR__ . '/../Repository/CommandeRepository.php';

class CommandeService
{
    private CommandeRepository $commande_repository;

    public function __construct()
    {
        $this->commande_repository = new CommandeRepository();
    }
    public function add(Commande $commande): void
    {
        $this->commande_repository->add($commande);
    }
    public function update(int $id, Commande $cmd)
    {
        $this->commande_repository->update($id, $cmd);
    }
    public function delete(int $id): void
    {
        $this->commande_repository->delete($id);
    }
    public function AsDeeleted(int $id,int $isdelt)
    {
        $this->commande_repository->AsDeeleted($id,$isdelt);
    }
    public function selectAllCommnd(): array
    {
        return $this->commande_repository->selectAll();
    }
    public function selectCmndById(int $cmnd_id,int $C_id)
    {
        return $this->commande_repository->selectCmndById( $cmnd_id, $C_id);
    }
    public function  selectById(int $cmnd_id)
    {
        return $this->commande_repository->selectById( $cmnd_id);
    }
    public function selectAllCommndClient(int $id)
    {
        return $this->commande_repository->selectAllCmndClient($id);
    }
}
