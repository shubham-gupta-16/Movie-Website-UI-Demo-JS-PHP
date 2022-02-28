# 123MKV AdFree Website - JSOUP PHP


![Project Flowchart](./output_images/flow.png)


## Screenshots


![Home Page](./output_images/2022-02-28-114532.png)
![Movie Details Page](./output_images/2022-02-28-114705.png)
![Online Player](./output_images/2022-02-28-115004.png)
![Responsive UI](./output_images/2022-02-28-115205.png)

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

**Response:**
```
{
  "pages": 260,
  "documents": [
    {
      "uri": "2001-movies/heartbreakers-full-movie-download-free-dual-audio-hd/",
      "name": "Heartbreakers",
      "year": "2001",
      "image": "https://123mkv.blue/wp-content/uploads/2022/02/Heartbreakers-Full-Movie-Download-Free-2001-Dual-Audio-HD.jpg"
    },
    
    ...

    {
      "uri": "2022-movies/moonfall-full-movie-download-free-dual-audio-hd/",
      "name": "Moonfall",
      "year": "2022",
      "image": "https://123mkv.blue/wp-content/uploads/2021/12/Moonfall-Full-Movie-Download-Free-2022-Dual-Audio-HD.jpg"
    }
  ]
}
```
### Get Movie Info

```
GET api/document?uri=2022-movies\/moonfall-full-movie-download-free-dual-audio-hd\/
```
**Note:**
- uri must be url encoded.

**Response:**
```
{
  "name": "Moonfall",
  "year": "2022",
  "image": "https://i1.wp.com/123mkv.red/wp-content/uploads/2021/12/Moonfall-Full-Movie-Download-Free-2022-Dual-Audio-HD-203x300.jpg?resize=203%2C300&#038;ssl=1",
  "audio": "Hindi – English",
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
      "uri": "hindi-dubbed-movies/final-destination-full-movie-download-free-dual-audio-hd/",
      "name": "Final Destination",
      "year": "2000",
      "image": "https://123mkv.buzz/wp-content/uploads/2020/12/Final-Destination-Full-Movie-Download-Free-2000-Dual-Audio-HD.jpg"
    },
    {
      "uri": "2018-movies/the-stolen-princess-full-movie-download-dual-audio/",
      "name": "The Stolen Princess",
      "year": "2018",
      "image": "https://123mkv.buzz/wp-content/uploads/2019/01/The-Stolen-Princess-Full-Movie-Download-free-2018-dual-audio.jpg"
    },
    {
      "uri": "2021-movies/every-last-one-of-them-full-movie-download-free-hd/",
      "name": "Every Last One of Them",
      "year": "2021",
      "image": "https://123mkv.buzz/wp-content/uploads/2021/10/Every-Last-One-of-Them-Full-Movie-Download-Free-2021-HD.jpg"
    }
  ],
  "token": "WnKcZLrwwUA0fLK7SRsw8KzYxurb+3H+8TUKHScdC71m/q/0S7o0TK0zufGrnoJ5sZaWwYoZx12iFsD8Qcs5kg42lVGh/j50LtSZiDSHpPFPFLQiiqU9YZPLbblR1aci"
}
```
### Get Download URL and Screenshots

```
GET api/download.php?token=WnKcZLrwwUA0fLK7SRsw8KzYxurb%2B3H%2B8TUKHScdC71m%2Fq%2F0S7o0TK0zufGrnoJ5sZaWwYoZx12iFsD8Qcs5kg42lVGh%2Fj50LtSZiDSHpPFPFLQiiqU9YZPLbblR1aci
```
**Note:** 
- You can get the token in movie info response.
- If token is not present there, that means the movie is not available for download or not released yet.
- Token must be send as url encoded.

**Response:**
```
{
  "url": "https://srv8.afiles.xyz/downmkv.php?filename=Oozham.2016.Webrip.720P.Hindi.Aac.2.0.X264.mkv&id=02d24175ab81e0b17721c858e5dcdaa5&key=1646071483",
  "screenshots": [
    "https://123mkv.buzz//screenshots/Oozham.2016.Webrip.720P.Hindi.Aac.2.0.X264.mkv%201%20(1).jpg",
    "https://123mkv.buzz//screenshots/Oozham.2016.Webrip.720P.Hindi.Aac.2.0.X264.mkv%201%20(2).jpg",
    "https://123mkv.buzz//screenshots/Oozham.2016.Webrip.720P.Hindi.Aac.2.0.X264.mkv%201%20(3).jpg"
  ]
}
```