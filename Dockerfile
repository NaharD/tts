FROM php:7.2-cli

ENV RHVOICE_PATH /opt/RHVoice

RUN apt-get update

RUN apt-get install -y git
RUN apt-get install -y pkg-config
RUN apt-get install -y scons

# бібліотека для виведення аудіо, вона дозволяє зберігари виведення в файл.
RUN apt-get install -y libao-dev
# утиліта, що дозволяє конвертувати wav в mp3
RUN apt-get install -y lame

RUN apt-get install -y python3 python-pip
RUN pip install lxml

# Викачуємо сирцевий код з репозиторію та збираємо його
RUN git clone https://github.com/Olga-Yakovleva/RHVoice.git $RHVOICE_PATH
WORKDIR $RHVOICE_PATH

RUN scons install
RUN ldconfig

ADD ./www/ /var/www/html/
ADD ./voice/dicts /usr/local/etc/RHVoice/dicts/

WORKDIR /var/www/html

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080"]
