<?php
class Game {
    private $db;
    private $idgame;
    private $name;

    public function __construct($dbConnection, $idgame = null, $name = null) {
        $this->db = $dbConnection;
        $this->idgame = $idgame;
        $this->name = $name;
    }

    // Getter and Setter
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

    //METHOD
    public function getGames($limit = 5, $start = 0) {
        $sql = "SELECT * FROM game LIMIT ?, ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $start, $limit);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function getGame($idgame) {

        $sql = "SELECT * FROM game WHERE idgame = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $idgame);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function getTotalGames() {
        $sql = "SELECT COUNT(*) AS total FROM game";
        $result = $this->db->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    public function insertGame($name, $description) {
        $sql = "INSERT INTO game (name, description) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql); 
        $stmt->bind_param("ss", $name, $description); 
        $stmt->execute(); 
        return $stmt->affected_rows; 
    }
    
    public function deleteGame($idgame) {
        $sql = "DELETE FROM game WHERE idgame = ?";
        $stmt = $this->db->prepare($sql); 
        $stmt->bind_param("i", $idgame);  
        $stmt->execute();               
        return $stmt->affected_rows;     
    }
    
    public function updateGame($idgame, $name, $description) {
        $sql = "UPDATE game SET name = ?, description = ? WHERE idgame = ?";
        $stmt = $this->db->prepare($sql); 
        $stmt->bind_param("ssi", $name, $description, $idgame); 
        $stmt->execute(); 
        return $stmt->affected_rows; 
    }

    public function getGameByTeam($idteam) {
        $sql = "SELECT g.* 
                FROM game g
                INNER JOIN  team t on g.idgame=t.idgame
                WHERE t.idteam = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $idteam);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    
}
?>
