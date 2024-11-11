<?php
class Team {
    private $db;
    private $idteam;
    private $idgame;
    private $name;

    // Constructor 
    public function __construct($dbConnection, $idteam = null, $idgame = null, $name = null) {
        $this->db = $dbConnection;
        $this->idteam = $idteam;
        $this->idgame = $idgame;
        $this->name = $name;
    }

    // Getter and Setter 
    public function getIdteam() {
        return $this->idteam;
    }
    public function setIdteam($idteam) {
        $this->idteam = $idteam;
    }
    public function getIdgame() {
        return $this->idgame;
    }
    public function setIdgame($idgame) {
        $this->idgame = $idgame;
    }
    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        $this->name = $name;
    }

    // Method 
    public function getTeams($start, $limit) {
        $sql = "SELECT t.idteam, g.name as game, t.name
                FROM game g INNER JOIN team t ON g.idgame = t.idgame
                LIMIT ?, ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $start, $limit);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function getTotalTeams() {
        $result = $this->db->query("SELECT COUNT(*) AS total FROM team");
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    public function deleteTeam($id) {
        $sql = "DELETE FROM team WHERE idteam = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
