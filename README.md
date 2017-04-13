# DutchGeo
Get latitude / longitude by Dutch postal / zip code. An easy job if you speak Dutch but for a not native speaker a bit of a search.

## Getting Started

Just install with composer, call Postal::getLatLong('1421AW'); and you are all done. The script uses curl so you need php with lib curl or copy/paste the sourcecode and use file_get_contents.

## Author

* Anton Boutkam

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Usage
```
try{
    $oLatLong = Postal::getLatLong('1421AW');

}
catch(NotFoundException $e)
{
   // The postal was not found, is it a real address?
   // Make someone fix the addresss?
}
catch(InvalidArgumentException $e)
{
   // The format of the postal/zip code is does not comply with Dutch standards: /^[0-9]{4}[A-Z]{2}$/, 
   // Make someone fix the addresss?
}
catch(ApiException $e)
{
   // Have a look at your cronjob / script. To many queries maybe?
}
```


![Build status](https://img.shields.io/circleci/project/antonboutkam/dutch-postal-to-latlong.svg?style=flat-square)

