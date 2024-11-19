<?php

namespace App\Models;

use CodeIgniter\Model;

class Email_Model extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'emailtemplates';
    protected $primaryKey       = 'emailtemplateid';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['type', 'slug', 'language', 'name', 'subject', 'message', 'fromname', 'plaintext', 'active', 'order'];

    public function getEmailTemplate($where='')
    {
        if (\is_array($where)) {
            return $this->where($where)->first();
        }

        return $this->findAll();
    }

    public function updateTemplate($where, $data)
    {
        return $this->update($where, $data);
    }
}
