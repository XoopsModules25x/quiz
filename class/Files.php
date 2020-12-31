<?php

namespace XoopsModules\Xquiz;

// $Id: class.sfiles.php,v 1.10 2004/09/02 17:04:08 hthouzard Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <https://xoops.org>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------- //

defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

use XoopsModules\Xquiz\{
    Helper,
    Mimetype,
    Quiz,
    Question
};

/**
 * Class Files
 * @package XoopsModules\Xquiz
 */
class Files
{
    public $db;
    public $table;
    public $fileid;
    public $filerealname;
    public $storyid;
    public $date;
    public $mimetype;
    public $downloadname;
    public $counter;

    /**
     * Files constructor.
     * @param int $fileid
     */
    public function __construct($fileid = -1)
    {
        $this->db           = \XoopsDatabaseFactory::getDatabaseConnection();
        $this->table        = $this->db->prefix('stories_files');
        $this->storyid      = 0;
        $this->filerealname = '';
        $this->date         = 0;
        $this->mimetype     = '';
        $this->downloadname = 'downloadfile';
        $this->counter      = 0;
        if (is_array($fileid)) {
            $this->makeFile($fileid);
        } elseif (-1 != $fileid) {
            $this->getFile((int)$fileid);
        }
    }

    /**
     * @param       $folder
     * @param       $filename
     * @param false $trimname
     * @return string
     */
    public function createUploadName($folder, $filename, $trimname = false)
    {
        $workingfolder = $folder;
        if ('/' <> xoops_substr($workingfolder, strlen($workingfolder) - 1, 1)) {
            $workingfolder .= '/';
        }
        $ext  = basename($filename);
        $ext  = explode('.', $ext);
        $ext  = '.' . $ext[count($ext) - 1];
        $true = true;
        while ($true) {
            $ipbits = explode('.', $_SERVER['REMOTE_ADDR']);
            [$usec, $sec] = explode(' ', microtime());

            $usec *= 65536;
            $sec  = ((integer)$sec) & 0xFFFF;

            if ($trimname) {
                $uid = sprintf('%06x%04x%04x', ($ipbits[0] << 24) | ($ipbits[1] << 16) | ($ipbits[2] << 8) | $ipbits[3], $sec, $usec);
            } else {
                $uid = sprintf('%08x-%04x-%04x', ($ipbits[0] << 24) | ($ipbits[1] << 16) | ($ipbits[2] << 8) | $ipbits[3], $sec, $usec);
            }
            if (!file_exists($workingfolder . $uid . $ext)) {
                $true = false;
            }
        }
        return $uid . $ext;
    }

    /**
     * @param string $filename
     * @return string
     */
    public function giveMimetype($filename = '')
    {
        $cmimetype   = new Mimetype();
        $workingfile = $this->downloadname;
        if ('' != xoops_trim($filename)) {
            $workingfile = $filename;
            return $cmimetype->getType($workingfile);
        } else {
            return '';
        }
    }

    /**
     * @param $storyid
     * @return array
     */
    public function getAllbyStory($storyid)
    {
        $ret    = [];
        $sql    = 'SELECT * FROM ' . $this->table . ' WHERE storyid=' . (int)$storyid;
        $result = $this->db->query($sql);
        while (false !== ($myrow = $this->db->fetchArray($result))) {
            $ret[] = new Files($myrow);
        }
        return $ret;
    }

    /**
     * @param $id
     */
    public function getFile($id)
    {
        $sql   = 'SELECT * FROM ' . $this->table . ' WHERE fileid=' . (int)$id;
        $array = $this->db->fetchArray($this->db->query($sql));
        $this->makeFile($array);
    }

    /**
     * @param $array
     */
    public function makeFile($array)
    {
        foreach ($array as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * @return bool
     */
    public function store()
    {
        $myts         = \MyTextSanitizer::getInstance();
        $fileRealName = $myts->addSlashes($this->filerealname);
        $downloadname = $myts->addSlashes($this->downloadname);
        $date         = time();
        $mimetype     = $myts->addSlashes($this->mimetype);
        $counter      = (int)$this->counter;
        $storyid      = (int)$this->storyid;

        if (!isset($this->fileid)) {
            $newid        = (int)$this->db->genId($this->table . '_fileid_seq');
            $sql          = 'INSERT INTO ' . $this->table . ' (fileid, storyid, filerealname, date, mimetype, downloadname, counter) ' . 'VALUES (' . $newid . ',' . $storyid . ",'" . $fileRealName . "','" . $date . "','" . $mimetype . "','" . $downloadname . "'," . $counter . ')';
            $this->fileid = $newid;
        } else {
            $sql = 'UPDATE ' . $this->table . ' SET storyid=' . $storyid . ",filerealname='" . $fileRealName . "',date=" . $date . ",mimetype='" . $mimetype . "',downloadname='" . $downloadname . "',counter=" . $counter . ' WHERE fileid=' . $this->getFileid();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        return true;
    }

    /**
     * @param string $workdir
     * @return bool
     */
    public function delete($workdir = XOOPS_UPLOAD_PATH)
    {
        $sql = 'DELETE FROM ' . $this->table . ' WHERE fileid=' . $this->getFileid();
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        if (is_file($workdir . '/' . $this->downloadname)) {
            unlink($workdir . '/' . $this->downloadname);
        }
        return true;
    }

    /**
     * @return bool
     */
    public function updateCounter()
    {
        $sql = 'UPDATE ' . $this->table . ' SET counter=counter+1 WHERE fileid=' . $this->getFileid();
        if (!$result = $this->db->queryF($sql)) {
            return false;
        }
        return true;
    }

    // ****************************************************************************************************************
    // All the Sets
    // ****************************************************************************************************************
    /**
     * @param $filename
     */
    public function setFileRealName($filename)
    {
        $this->filerealname = $filename;
    }

    /**
     * @param $id
     */
    public function setStoryid($id)
    {
        $this->storyid = (int)$id;
    }

    /**
     * @param $value
     */
    public function setMimetype($value)
    {
        $this->mimetype = $value;
    }

    /**
     * @param $value
     */
    public function setDownloadname($value)
    {
        $this->downloadname = $value;
    }

    // ****************************************************************************************************************
    // All the Gets
    // ****************************************************************************************************************
    /**
     * @return int
     */
    public function getFileid()
    {
        return (int)$this->fileid;
    }

    /**
     * @return int
     */
    public function getStoryid()
    {
        return (int)$this->storyid;
    }

    /**
     * @return int
     */
    public function getCounter()
    {
        return (int)$this->counter;
    }

    /**
     * @return int
     */
    public function getDate()
    {
        return (int)$this->date;
    }

    /**
     * @param string $format
     * @return string
     */
    public function getFileRealName($format = 'S')
    {
        $myts = \MyTextSanitizer::getInstance();
        switch ($format) {
            case 'S':
            case 'Show':
                $filerealname = htmlspecialchars($this->filerealname, ENT_QUOTES | ENT_HTML5);
                break;
            case 'E':
            case 'Edit':
                $filerealname = htmlspecialchars($this->filerealname, ENT_QUOTES | ENT_HTML5);
                break;
            case 'P':
            case 'Preview':
                $filerealname = htmlspecialchars(($this->filerealname), ENT_QUOTES | ENT_HTML5);
                break;
            case 'F':
            case 'InForm':
                $filerealname = htmlspecialchars(($this->filerealname), ENT_QUOTES | ENT_HTML5);
                break;
        }
        return $filerealname;
    }

    /**
     * @param string $format
     * @return string
     */
    public function getMimetype($format = 'S')
    {
        $myts = \MyTextSanitizer::getInstance();
        switch ($format) {
            case 'S':
            case 'Show':
                $filemimetype = htmlspecialchars($this->mimetype, ENT_QUOTES | ENT_HTML5);
                break;
            case 'E':
            case 'Edit':
                $filemimetype = htmlspecialchars($this->mimetype, ENT_QUOTES | ENT_HTML5);
                break;
            case 'P':
            case 'Preview':
                $filemimetype = htmlspecialchars(($this->mimetype), ENT_QUOTES | ENT_HTML5);
                break;
            case 'F':
            case 'InForm':
                $filemimetype = htmlspecialchars(($this->mimetype), ENT_QUOTES | ENT_HTML5);
                break;
        }
        return $filemimetype;
    }

    /**
     * @param string $format
     * @return string
     */
    public function getDownloadname($format = 'S')
    {
        $myts = \MyTextSanitizer::getInstance();
        switch ($format) {
            case 'S':
            case 'Show':
                $filedownname = htmlspecialchars($this->downloadname, ENT_QUOTES | ENT_HTML5);
                break;
            case 'E':
            case 'Edit':
                $filedownname = htmlspecialchars($this->downloadname, ENT_QUOTES | ENT_HTML5);
                break;
            case 'P':
            case 'Preview':
                $filedownname = htmlspecialchars(($this->downloadname), ENT_QUOTES | ENT_HTML5);
                break;
            case 'F':
            case 'InForm':
                $filedownname = htmlspecialchars(($this->downloadname), ENT_QUOTES | ENT_HTML5);
                break;
        }
        return $filedownname;
    }

    // Deprecated

    /**
     * @param $storyid
     * @return mixed
     */
    public function getCountbyStory($storyid)
    {
        $sql    = 'SELECT count(fileid) as cnt FROM ' . $this->table . ' WHERE storyid=' . (int)$storyid . '';
        $result = $this->db->query($sql);
        $myrow  = $this->db->fetchArray($result);
        return $myrow['cnt'];
    }

    /**
     * @param $stories
     * @return array
     */
    public function getCountbyStories($stories)
    {
        $ret = [];
        if (count($stories) > 0) {
            $sql    = 'SELECT storyid, count(fileid) as cnt FROM ' . $this->table . ' WHERE storyid IN (';
            $sql    .= implode(',', $stories) . ') GROUP BY storyid';
            $result = $this->db->query($sql);
            while (false !== ($myrow = $this->db->fetchArray($result))) {
                $ret[$myrow['storyid']] = $myrow['cnt'];
            }
        }
        return $ret;
    }
}
