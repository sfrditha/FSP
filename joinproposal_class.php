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
}
?>
