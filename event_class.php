<?php
class Event {
    private $idevent;
    private $name;
    private $date;
    private $description;
    private $koneksi;

    public function __construct($koneksi, $idevent = null, $name = null, $date = null, $description = null) {
        $this->koneksi = $koneksi;
        $this->idevent = $idevent;
        $this->name = $name;
        $this->date = $date;
        $this->description = $description;
    }

    // Getter and Setter
    public function getIdevent() {
        return $this->idevent;
    }

    public function setIdevent($idevent) {
        $this->idevent = $idevent;
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

    public function getEvents($limit = 5, $start = 0) {
        $sql = "SELECT * FROM event LIMIT ?, ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("ii", $start, $limit);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getTotalEvents() {
        $sql = "SELECT COUNT(*) AS total FROM event";
        $result = $this->koneksi->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    public function deleteEvent($idevent) {
        $sql = "DELETE FROM event WHERE idevent = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("i", $idevent);
        $stmt->execute();
    }
}
?>
