#Встановлення

Створюємо теку в котру склонуємо цей проект

`mkdir tts`

Перейдемо в неї

`cd tts`

Клонуємо проект до себе.

`git clone https://github.com/NaharD/tts.git .`

Створюємо докер образ. Займає трохи часу.

`docker build -t tts .`

Запускаємо контейнер на базі щойно створеного образу.

`docker run -itdp 8080:8080 --name tts tts`

Тепер якщо ти перейдеш за цим посиланням, то почуєш озвучений текст.

http://localhost:8080?text=крута+українська+озвучка

Без задання профілю, голос буде від Анатоля (`anatol`), щоб озвучити текст голосом від Наталки, користуйся параметром `voice`

http://localhost:8080?text=крута+українська+озвучка&voice=natalia

Якщо озвучений файл для завантаження треба відповідно назвати, використовуй параметр `name`

http://localhost:8080?text=крута+українська+озвучка&voice=anatol&name=ukr_audio

Проект базується на https://github.com/Olga-Yakovleva/RHVoice