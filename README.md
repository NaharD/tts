# Встановлення та використання

Запускаємо контейнер.

`docker run -itdp 8080:8080 --name tts nagard/tts`

Тепер якщо ти перейдеш за цим посиланням, то почуєш озвучений текст.

http://localhost:8080?text=крута+українська+озвучка

Без задання профілю, голос буде від Анатоля (`anatol`), щоб озвучити текст голосом від Наталки (`natalia`), користуйся параметром `voice`

http://localhost:8080?text=крута+українська+озвучка&voice=natalia

Якщо озвучений файл для завантаження треба відповідно назвати, використовуй параметр `name`

http://localhost:8080?text=крута+українська+озвучка&voice=anatol&name=ukr_audio

#### Через docker-compose

```yaml
version: '2'
services:
    tts:
        image: nagard/tts
        ports:
          - "8088:8080"
```

Проект базується на https://github.com/Olga-Yakovleva/RHVoice
