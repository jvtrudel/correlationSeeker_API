# correlationSeeker API

Restful PHP API for economic and financial data exploration.

# Dependencies

## fred_api

  - php-curl



# JavaScript API usage

## Initialization

    api=new correlationSeeker_API()
        .config("config.json");  

The configuration file (config.json) must contain the API server's url.

## Root categories

    categories=api.select(0);

# Web API usage

    <web root>/api?method=<method>&id=<id>

## getChildCategories

**output**: [flag, result]

**flag**: true if result id a category list or false if its a serie id

**result**:
  - categorie list: [{id:,value:}]
  - serie id: string

## getSeriesInfo

## getSerie
