<?php
class JoinProposal {
    private $idjoin_proposal;
    private $idteam;
    private $idmember;
    private $description;
    private $status;
    private $koneksi;

    public function __construct($koneksi, $idjoin_proposal = null, $idteam = null, $idmember = null, $description = null, $status = null) {
        $this->koneksi = $koneksi;
        $this->idjoin_proposal = $idjoin_proposal;
        $this->idteam = $idteam;
        $this->idmember = $idmember;
        $this->description = $description;
        $this->status = $status;
    }

    // Getter and Setter
    public function getIdjoinProposal() {
        return $this->idjoin_proposal;
    }

    public function setIdjoinProposal($idjoin_proposal) {
        $this->idjoin_proposal = $idjoin_proposal;
    }

    public function getIdteam() {
        return $this->idteam;
    }

    public function setIdteam($idteam) {
        $this->idteam = $idteam;
    }

    public function getIdmember() {
        return $this->idmember;
    }

    public function setIdmember($idmember) {
        $this->idmember = $idmember;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getJoinProposals($limit = 5, $start = 0, $status_filter = 'all') {
        $sql = "SELECT jp.idjoin_proposal, jp.idteam, jp.idmember, jp.description, jp.status, t.name AS team_name, m.username AS member_name
                FROM join_proposal jp
                JOIN team t ON jp.idteam = t.idteam
                JOIN member m ON jp.idmember = m.idmember";

        if ($status_filter !== 'all') {
            $sql .= " WHERE jp.status = ?";
        }

        $sql .= " LIMIT ?, ?";
        
        $stmt = $this->koneksi->prepare($sql);
        if ($status_filter !== 'all') {
            $stmt->bind_param("sii", $status_filter, $start, $limit);
        } else {
            $stmt->bind_param("ii", $start, $limit);
        }
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getTotalJoinProposals($status_filter = 'all') {
        $sql = "SELECT COUNT(*) AS total FROM join_proposal";
        if ($status_filter !== 'all') {
            $sql .= " WHERE status = ?";
        }
        $stmt = $this->koneksi->prepare($sql);
        if ($status_filter !== 'all') {
            $stmt->bind_param("s", $status_filter);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    public function updateJoinProposalStatus($idjoin_proposal, $status) {
        $sql = "UPDATE join_proposal SET status = ? WHERE idjoin_proposal = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("si", $status, $idjoin_proposal);
        $stmt->execute();
    }

    public function memberStatus($idmember){
        $sql = "SELECT status FROM join_proposal WHERE idmember = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("i", $idmember);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function insertJoinProposal($idteam, $idmember, $description, $status){
        $sql = "INSERT INTO join_proposal (idteam, idmember, description, status) VALUES (?, ?, ?, ?)";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("iiss", $idteam, $idmember, $description, $status);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function getId_TeamMember($idproposal){
        $get_proposal_sql = "SELECT idteam, idmember FROM join_proposal WHERE idjoin_proposal = ?";
        $get_proposal_stmt = $this->koneksi->prepare($get_proposal_sql);
        $get_proposal_stmt->bind_param("i", $idproposal);
        $get_proposal_stmt->execute();
        return $get_proposal_stmt->get_result();
    }

    public function cekProposal($idteam, $idmember){
        $check_sql = "SELECT COUNT(*) AS count FROM team_members WHERE idteam = ? AND idmember = ?";
        $check_stmt = $this->koneksi->prepare($check_sql);
        $check_stmt->bind_param("ii", $idteam, $idmember);
        $check_stmt->execute();
        return $check_stmt->get_result();
    }

    public function statusApproved($idproposal){
        $insert_sql = "INSERT INTO team_members (idteam, idmember, description) 
                               SELECT idteam, idmember, description FROM join_proposal WHERE idjoin_proposal = ?";
        $insert_stmt = $this->koneksi->prepare($insert_sql);
        $insert_stmt->bind_param("i", $idproposal);
        $insert_stmt->execute();
        return $insert_stmt->affected_rows;
    }

    public function getTeams($idmember){
        $sql = "SELECT t.idteam, t.name
                FROM team t
                LEFT JOIN join_proposal jp ON t.idteam = jp.idteam AND jp.idmember = ?
                WHERE jp.idjoin_proposal IS NULL OR jp.status = 'rejected'";    
        $result = $this->koneksi->prepare($sql);
        $result->bind_param("i", $idmember);
        $result->execute();
        return $result->get_result();
    }

    public function getProposalsByMember($idmember) {
        $sql = "SELECT jp.idjoin_proposal, jp.description, jp.status, 
                       t.name AS team_name, g.name AS game_name 
                FROM join_proposal jp
                JOIN team t ON jp.idteam = t.idteam
                JOIN game g ON t.idgame = g.idgame
                WHERE jp.idmember = ?";
                
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("i", $idmember);
        $stmt->execute();
        return $stmt->get_result();
    }
    
}
?>
