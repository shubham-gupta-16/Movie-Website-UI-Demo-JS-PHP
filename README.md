# 123MKV AdFree Website - JSOUP PHP


![Project Flowchart](./output_images/flow.png)


## Screenshots


![Home Page](./output_images/2022-02-21-195410.png)
![Movie Details Page](./output_images/2022-02-21-195601.png)
![Online Player](./output_images/2022-02-21-195718.png)

## Screenshot of original 123MKV website with Ads

![123MKV](./output_images/123mkv.png)


This website is created for educational purpose. It uses the data of 123MKV. It never promote piracy of copyright content.

## API Documentation:

### Get Movies List

```
GET api/
GET api/?page=2
GET api/?s=spiderman
GET api/?s=spiderman&page=2
```
Response:
```
{
  "pages": 260,
  "documents": [
    {
      "uri": "2001-movies/heartbreakers-full-movie-download-free-dual-audio-hd/",
      "name": "Heartbreakers",
      "description": "(2001) Dual Audio 720p BluRa...",
      "image": "https://123mkv.blue/wp-content/uploads/2022/02/Heartbreakers-Full-Movie-Download-Free-2001-Dual-Audio-HD.jpg"
    },
    
    ...

    {
      "uri": "2022-movies/moonfall-full-movie-download-free-dual-audio-hd/",
      "name": "Moonfall",
      "description": "(2022) Dual Audio 720p HDCam 889mb",
      "image": "https://123mkv.blue/wp-content/uploads/2021/12/Moonfall-Full-Movie-Download-Free-2022-Dual-Audio-HD.jpg"
    }
  ]
}
```
