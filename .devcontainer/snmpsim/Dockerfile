FROM python:3.11-slim

ARG USERNAME=snmpsim
ARG USER_UID=1000
ARG USER_GID=$USER_UID

RUN groupadd --gid $USER_GID $USERNAME && useradd --uid $USER_UID --gid $USER_GID -m $USERNAME

ADD entrypoint.sh /usr/bin/entrypoint.sh
RUN chmod +x /usr/bin/entrypoint.sh

RUN pip install pysnmp snmpclitools snmpsim

VOLUME /usr/snmpsim/data
EXPOSE 1161/udp

ENTRYPOINT ["entrypoint.sh", "--agent-udpv4-endpoint=0.0.0.0:1161", "--process-user=snmpsim", "--process-group=nogroup", "--data-dir=/usr/snmpsim/data"]
