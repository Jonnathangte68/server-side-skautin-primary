<?php

namespace App\Factories;

use App\Interfaces\PlaylistCreatorFactory;
use App\TalentPlaylists;
use App\StoreAssetOnPlaylist;
use App\Utils\Logger;


class TalentPlaylistFactory implements PlaylistCreatorFactory
{
  public function createPlaylist(Array $input)
  {
      $playlist = new TalentPlaylists;
      $playlist->talent_id = $input['talent_id'];
      $playlist->save();
      foreach($input['assets'] as $asset) {
          $assetCreator = new StoreAssetOnPlaylist($asset, $playlist->id);
      }
      return true;
  }
}