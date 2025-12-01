<?php
require_once('model.php');

class Restaurant extends Model
{
    protected $table = 'T_RSTINFO';

    // 店舗一覧取得
    public function getList()
    {
        $sql = "SELECT 
                    RST_ID,
                    RST_NAME,
                    RST_ADDRESS,
                    START_TIME,
                    END_TIME,
                    TEL_NUM,
                    RST_PAY,
                    RST_INFO,
                    PHOTO1,
                    DISCOUNT
                FROM {$this->table}
                ORDER BY RST_ID ASC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 店舗詳細取得
    public function getDetail($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE RST_ID = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 店舗登録
    public function insert($data)
    {
        return parent::insert($data);
    }

    // 店舗更新
    public function update($data, $where)
    {
        return parent::update($data, $where);
    }

    // 店舗削除
    public function delete($where)
    {
        return parent::delete($where);
    }
}
