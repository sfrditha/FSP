<?php
class Achievement {
    private $idachievement;
    private $idteam;
    private $name;
    private $date;
    private $description;
    private $koneksi;

    public function __construct($koneksi, $idachievement = null, $idteam = null, $name = null, $date = null, $description = null) {
        $this->koneksi = $koneksi;
        $this->idachievement = $idachievement;
        $this->idteam = $idteam;
        $this->name = $name;
        $this->date = $date;
        $this->description = $description;
    }

    // Getter and Setter
    public function getIdachievement() {
        return $this->idachievement;
    }

    public function setIdachievement($idachievement) {
        $this->idachievement = $idachievement;
    }

    public function getIdteam() {
        return $this->idteam;
    }

    public function setIdteam($idteam) {
        $this->idteam = $idteam;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getAchievements($limit = 5, $start = 0) {
        $sql = "SELECT achievement.idachievement, team.name AS team_name, achievement.name, achievement.date, achievement.description
                FROM achievement
                JOIN team ON achievement.idteam = team.idteam
                LIMIT ?, ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("ii", $start, $limit);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getTotalAchievements() {
        $sql = "SELECT COUNT(*) AS total FROM achievement";
        $result = $this->koneksi->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    public function deleteAchievement($idachievement) {
        $sql = "DELETE FROM achievement WHERE idachievement = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("i", $idachievement);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function getAchievement($idachievement) {
        $sql = "SELECT * FROM achievement WHERE idachievement = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("i",$idachievement);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function updateAchievement($idteam, $name, $date, $description, $idachievement){
        $sql = "UPDATE achievement SET idteam = ?, name = ?, date = ?, description = ? WHERE idachievement = ?";
		$stmt = $this->koneksi->prepare($sql);
		$stmt->bind_param("isssi", $idteam, $name, $date, $description, $idachievement);
		$stmt->execute();
        return $stmt->affected_rows;
    }

    public function insertAchievement($teamid, $name, $date, $description){
        $sql = "INSERT INTO achievement (idteam, name, date, description) VALUES (?, ?, ?, ?)";
		$stmt = $this->koneksi->prepare($sql);
		$stmt->bind_param("isss", $teamid, $name, $date, $description);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function getAllAchievements() {
        $sql = "SELECT achievement.idachievement, team.name AS team_name, achievement.name, achievement.date, achievement.description
                FROM achievement
                JOIN team ON achievement.idteam = team.idteam";
        return $this->koneksi->query($sql);
    }

    public function searchAchievements($keyword) {
        $keyword = "%{$keyword}%";
        $sql = "SELECT achievement.idachievement, team.name AS team_name, achievement.name, achievement.date, achievement.description
                FROM achievement
                JOIN team ON achievement.idteam = team.idteam
                WHERE achievement.name LIKE ? OR achievement.description LIKE ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("ss", $keyword, $keyword);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
