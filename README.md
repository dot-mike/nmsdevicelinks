# nmsdevicelinks

nmsdevicelinks - A LibreNMS plugin that allows you to create and manage external device links directly from the LibreNMS web UI. Instead of having to execute CLI commands to add custom links, this plugin makes it possible to manage device links directly from the LibreNMS web UI.

This plugin supports two types of links:

- External links: These are links to external resources that are not part of LibreNMS.
- SNMP Command Links: These are special links that allow you to execute **SNMP Set** command on the device and the result will be displayed in the LibreNMS web UI.

## Notes

The primary reason this was developed was to add support for SNMP Set commands in LibreNMS. This feature is not available in the LibreNMS application, and this plugin provides a way to execute SNMP Set commands directly from the LibreNMS web UI.

The plugin administration page is only allowed for users with the `admin` role. As such, only users with the `admin` role can add, edit, and delete device links. But there are no restrictions on who can view the device links and use them. So be careful when adding SNMP Set commands, as they can be executed by anyone who has access to the device page.

The SNMP commands are executed with the same SNMP version and community string as the device is configured with in LibreNMS. So if the device is configured with SNMPv3, the SNMP Set command will be executed with SNMPv3. Also the commands are directly executed from the LibreNMS web-server it-self. So make sure that the server has network access to the device. This is a limitation as there is no way for a disptacher (worker) execute the commands.

## Screenshots

![manage-device-links](/screenshots/manage-device-links.png?raw=true)
![manage-snmp-commands](/screenshots/manage-snmp-commands.png?raw=true)
![device-links](/screenshots/device-links.png?raw=true)

## Installation

### Without Docker

Go to the LibreNMS base directory and run the following commands as librenms user:

```bash
./lnms plugin:add dot-mike/nmsdevicelinks
php artisan route:clear
php lnms --force -n migrate
```

### With Docker

If you are using LibreNMS with Docker, you can install the plugin by customizing the Dockerfile.

Example Dockerfile:

```Dockerfile
ARG VERSION=librenms:23.8.2
FROM librenms/$VERSION

RUN apk --update --no-cache add -t build-dependencies php-xmlwriter
RUN mkdir -p "${LIBRENMS_PATH}/vendor"

RUN echo $'#!/usr/bin/with-contenv sh\n\
set -e\n\
if [ "$SIDECAR_DISPATCHER" = "1" ] || [ "$SIDECAR_SYSLOGNG" = "1" ] || [ "$SIDECAR_SNMPTRAPD" = "1" ]; then\n\
  exit 0\n\
fi\n\
chown -R librenms:librenms "${LIBRENMS_PATH}/composer.json" "${LIBRENMS_PATH}/composer.lock" "${LIBRENMS_PATH}/vendor"\n\
lnms plugin:add dot-mike/nmsdevicelinks\n\
php artisan route:clear\n\
php lnms --force -n migrate\n\
' > /etc/cont-init.d/99-nmsdevicelinks.sh
```

## Usage

To get started, open LibreNMS and enable the plugin by navigating to Overview->Plugins->Plugins Admin and enable the `nmsdevicelinks` plugin.


## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.


## Credits

Thanks to the [LibreNMS](https://github.com/librenms/librenms/) team and the exampleplugin [ExamplePlugin](https://github.com/librenms/librenms/tree/master/app/Plugins/ExamplePlugin) for the inspiration.

