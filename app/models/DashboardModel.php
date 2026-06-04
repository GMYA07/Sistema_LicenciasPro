<?php

require_once __DIR__ . '/../../core/Database.php';


class DashboardModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    // funciones para poner en la carta de dhashboard
    public function TotalComputadorasRegistradas()
    {
        $sql = 'SELECT COUNT(*) AS total_computadoras FROM computadoras;';
        $stmt = $this->db->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_computadoras'];
    }

    public function LicienciasActivas()
    {
        $sql = 'SELECT COUNT(*) AS licencias_instaladas FROM licencias WHERE estadoLicencia = "Instalada";';
        $stmt = $this->db->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC)['licencias_instaladas'];
    }

    public function PróximasExpirar()
    {
        $sql = 'SELECT COUNT(*) AS proximas_a_vencer FROM licencias 
        WHERE estadoLicencia = "Instalada" AND fechaCaducacion BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 30 DAY);';
        $stmt = $this->db->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC)['proximas_a_vencer'];
    }

    public function totalAreas()
    {
        $sql = 'SELECT COUNT(*) AS total_areas FROM areas;';
        $stmt = $this->db->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_areas'];
    }

    // funciones para poner en las estadisticas del dashboard
    public function graficaPastel()
    {
        $sql = 'SELECT estadoLicencia, COUNT(*) AS cantidad 
                FROM licencias 
                GROUP BY estadoLicencia;';
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        public function graficaBarras()
        {
            $sql = 'SELECT tl.categoriaLicencia, COUNT(l.idLicencia) AS cantidad_licencias
                    FROM tipolicencias tl
                    LEFT JOIN licencias l ON tl.idTipoLicencia = l.idTipoLicencia
                    GROUP BY tl.categoriaLicencia;';
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        // funciones para poner en la tabla de proximas a vencer
       public function DetalleOperativo() {
    // Usamos comillas dobles al inicio y al final para poder usar comillas simples adentro
    $sql = "
        SELECT 
            a.nombreArea AS `Área`,
            a.edificio AS `Edificio`,
            CONCAT(c.Marca, ' ', c.Modelo) AS `Computadora`,
            tl.nombreTipoLicencia AS `Licencia`,
            l.codigoLicencia AS `Código`,
            DATE_FORMAT(l.fechaCaducacion, '%d/%m/%Y') AS `Vence El`
        FROM licencias_detalles ld
        INNER JOIN computadoras c ON ld.id_computadora = c.idComputadora
        INNER JOIN areas a ON c.idAreaComputadora = a.idArea
        INNER JOIN licencias l ON ld.id_licencia = l.idLicencia
        INNER JOIN tipolicencias tl ON l.idTipoLicencia = tl.idTipoLicencia
        ORDER BY l.fechaCaducacion ASC
    ";
    
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



}