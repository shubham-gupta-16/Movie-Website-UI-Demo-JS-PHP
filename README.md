# 123MKV AdFree Website - JSOUP PHP


![Project Flowchart](./output_images/flow.png)


## Screenshots


![Home Page](./output_images/2022-02-26-112231.png)
![Movie Details Page](./output_images/2022-02-26-112507.png)
![Online Player](./output_images/2022-02-26-112902.png)

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

GET api/?category=south-movies
GET api/?category=hindi-dubbed-movies&page=2

GET api/?year=2022
GET api/?year=2000&page=2

```
- Year: 2000 to Current Year
- Categories: hindi-movies, hollywood-movies, hindi-dubbed-movies, south-movies, old-movies

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
### Get Movie Info

```
GET api/document.php?uri=2022-movies\/moonfall-full-movie-download-free-dual-audio-hd\/
```
Note: uri must be url encoded.

Response:
```
{
  "name": "Moonfall",
  "year": "2022",
  "language": "Hindi – English",
  "size": "889mb",
  "quality": "720p HDCam",
  "genres": "Action, Adventure, Fantasy",
  "country": "United States, Canada, China, United Kingdom",
  "actors": "Halle Berry, Patrick Wilson, John Bradley",
  "info": [
    "Moonfall is an impending sci-fi activity movie, co-composed and coordinated by Roland Emmerich. It stars Halle Berry, Patrick Wilson, John Bradley, Charlie Plummer, Michael Peña, and Donald Sutherland.",
    "Moonfall is planned to be delivered dramatically on February 4, 2022, by Lionsgate.\r\n A secretive power thumps the Moon from its circle around Earth and sends it plunging on an impact course with life as far as we might be concerned. With only a short time before sway and the world near the very edge of destruction, NASA leader and previous space traveler Jo Fowler (Halle Berry) is persuaded she has the way to saving all of us – yet just a single space explorer from quite a while ago, Brian Harper (Patrick Wilson) and connivance scholar K.C. Houseman (John Bradley) trust her."
  ],
  "related": [
    {
      "uri": "2020-movies\/the-old-ways-full-movie-download-free-hd\/",
      "name": "The Old Ways",
      "year": "2020",
      "image": "https:\/\/123mkv.buzz\/wp-content\/uploads\/2021\/08\/The-Old-Ways-Full-Movie-Download-Free-2020-HD.jpg"
    },
    {
      "uri": "2015-movies\/ant-man-full-movie-download-free-dual-audio-hd1\/",
      "name": "Ant-Man",
      "year": "2015",
      "image": "https:\/\/123mkv.buzz\/wp-content\/uploads\/2020\/12\/Ant-Man-Full-Movie-Download-Free-2015-Dual-Audio-HD.jpg"
    },
    {
      "uri": "2021-movies\/friends-the-reunion-full-movie-download-hd-free\/",
      "name": "Friends: The Reunion",
      "year": "2021",
      "image": "https:\/\/123mkv.buzz\/wp-content\/uploads\/2021\/05\/Friends-The-Reunion-Full-Movie-Download-Free-2021-HD.jpg"
    }
  ],
  "token": "N8tyW1bzM9aOyJIX9c8ZgPUwkoGNNq80ObDO1Hwkto0r6OC9VCINqqBKG6Z2cXru43oF60kfkrlMTRRHjCsrea6fm3YKZy7vN0HWbB3F3V8="
}
```
### Get Download URL and Screenshots

```
GET api/download.php?token=N8tyW1bzM9aOyJIX9c8ZgPUwkoGNNq80ObDO1Hwkto0r6OC9VCINqqBKG6Z2cXru43oF60kfkrlMTRRHjCsrea6fm3YKZy7vN0HWbB3F3V8=.
```
Note: You can get the token in movie info response. If token is not present there, that means the movie is not available for download or not released yet.

Response:
```
{
  "url": "https:\/\/srv14.dfiles.xyz\/downmkv.php?filename=Moonfall.2022.Hdcam.720P.Hindi.English.Aac.2.0.X264.mkv&id=144342884c883f04066cc281c469db38&key=1645825168",
  "screenshots": [
    "https:\/\/123mkv.buzz\/\/screenshots\/Moonfall.2022.Hdcam.720P.Hindi.English.Aac.2.0.X264.mkv%201%20(1).jpg",
    "https:\/\/123mkv.buzz\/\/screenshots\/Moonfall.2022.Hdcam.720P.Hindi.English.Aac.2.0.X264.mkv%201%20(2).jpg",
    "https:\/\/123mkv.buzz\/\/screenshots\/Moonfall.2022.Hdcam.720P.Hindi.English.Aac.2.0.X264.mkv%201%20(3).jpg"
  ]
}
```


