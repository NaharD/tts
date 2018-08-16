FROM php:7.2

ENV RHVOICE_PATH /opt/RHVoice

RUN apt-get update

RUN apt-get install -y git
RUN apt-get install -y pkg-config
RUN apt-get install -y scons

# бібліотека для виведення аудіо, вона дозволяє зберігари виведення в файл.
RUN apt-get install -y libao-dev
# утиліта, що дозволяє конвертувати wav в mp3
RUN apt-get install -y lame

# Викачуємо сирцевий код з репозиторію та збираємо його
RUN git clone https://github.com/Olga-Yakovleva/RHVoice.git $RHVOICE_PATH
WORKDIR $RHVOICE_PATH
RUN scons
RUN scons install
RUN ldconfig

# Видаляємо непотрібні файли для заощадження вільного простору
RUN rm -rf $RHVOICE_PATH
RUN apt-get purge -y git
RUN apt-get purge -y pkg-config
RUN apt-get purge -y scons
RUN apt-get purge -y binutils
RUN apt-get purge -y bzip2
RUN apt-get purge -y cpp
RUN apt-get purge -y dpkg-dev
RUN apt-get purge -y g++
RUN apt-get purge -y gcc
RUN apt-get purge -y libdpkg-perl
RUN apt-get purge -y make
RUN apt-get purge -y uuid-dev
RUN apt-get autoremove -y

ADD ./www/ /var/www/html/
ADD ./voice/dicts /usr/local/etc/RHVoice/dicts/

WORKDIR /var/www/html

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080"]
