<?php

namespace App\Service;

use DateTime;

class DecodingService
{
    public function __construct()
    {
        
    }

    /**
     * Function for get all information
     *
     * @param array $data the url of youtube content
     * @return array
     */
    public function getAllYoutubeMime(array $data) : array
    {
        $mimeTmp = array();
        $mime = array();

        exec('youtube-dl -F ' . $data['url'], $mimeTmp);

        array_splice($mimeTmp,0,3);

        foreach($mimeTmp as $key => $m)
        {
            $mTmp = explode('  ', $m);
            $mTmp = array_values(array_filter($mTmp));
            $mime[$key]['code'] = $mTmp[0];
            $mime[$key]['mime'] = $mTmp[1];
            $mime[$key]['type'] = $mTmp[2];
            $extra = explode(',',$mTmp[3]);
            $mime[$key]['quality'] = array_shift($extra);
            $mime[$key]['size'] = array_pop($extra);
            $mime[$key]['codec'] = implode("", $extra);
        }

        
        $fileNameTmp = array();

        exec('youtube-dl --get-filename ' . $data['url'], $fileNameTmp);
        $arrayTmp = explode('-',$fileNameTmp[0]);
        array_pop($arrayTmp);
        return ['mime' => $mime, 'fileName' => implode('-',$arrayTmp)];
    }

    public function downloadYoutube(array $data) : array
    {
        $mimeTmp = array();
        $date = new DateTime();
        $timestamp = $date->getTimestamp();
        exec('youtube-dl -f ' . $data['code'] . ' ' . $data['url'] . ' -o /'. $timestamp .'/%(title)s.%(ext)s', $mimeTmp);

        $arrayDir = scandir($timestamp);
        return ['mediaFile' => $timestamp . '/' . end($arrayDir), 'mediaName' => end($arrayDir)];
    }
}
