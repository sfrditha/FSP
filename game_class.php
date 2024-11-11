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

    public function getTotalGames() {
        $sql = "SELECT COUNT(*) AS total FROM game";
        $result = $this->db->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
}
?>
