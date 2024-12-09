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
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function getTeam($idteam){
        $sql = "SELECT * FROM team WHERE idteam = ?";
		$stmt = $this->db->prepare($sql);
		$stmt->bind_param("i", $idteam);
		$stmt->execute();
		return $stmt->get_result();
    }

    public function updateTeam($idgame, $team_name, $idteam){
        $sql = "UPDATE team SET idgame = ?, name = ? WHERE idteam = ?";
		$stmt = $this->db->prepare($sql);
		$stmt->bind_param("isi", $idgame, $team_name, $idteam);
		$stmt->execute();
        return $stmt->affected_rows;
    }
    public function insertTeam($idgame, $team_name){
        $sql = "INSERT INTO team (idgame, name) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("is", $idgame, $team_name);
        $stmt->execute();
        return $stmt->insert_id;
    }
    public function getIdTeams($idmember){
        $sql = "SELECT idteam FROM team_members WHERE idmember = ?;";
        $stmt = $this->db->prepare($sql);
		$stmt->bind_param("i", $idmember);
		$stmt->execute();
		return $stmt->get_result();
    }

    public function displayMembers($idteam){
        $sql = "SELECT tm.idteam, m.fname, m.lname, tm.description
                    FROM team_members tm
                    INNER JOIN member m ON tm.idmember = m.idmember
                    WHERE tm.idteam = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $idteam);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function displayAchievements($idteam){
        $sql = "SELECT * FROM achievement WHERE idteam = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $idteam);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function displayEvents($idteam){
        $sql = "SELECT * 
                    FROM event_teams et
                    INNER JOIN event e ON et.idevent = e.idevent
                    WHERE et.idteam = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $idteam);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
