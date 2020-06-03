# Cameras PTZ Control Library

Easy control your PTZ Cameras from PHP.

## Installation

Use the package manager [composer](https://getcomposer.org/) to install this package.

```bash
composer require arthurpatriot/ptz-cameras-control
```

## Basic Usage

```php
use PtzCamera\CameraMovement;

$camera = new CameraMovement('login', 'password', 'ip', 'port');

$camera->left();
$camera->right();
$camera->up();
$camera->down();
$camera->home();
```

## Supported Providers

* Hikvision
* Dahua
* ISAPI PTZ Cameras

> If your camera not in this list, contact with me, and we add support.


### Custom Provider

For using custom camera provider:
```php
$camera = new CameraMovement('login', 'password', 'ip', 'port', null, 'example-path');
```
Where `example-path`, `ISAPI/PTZCtrl` or ptz path for your device.

## Documentation

Visit [Wiki Pages](https://github.com/ArthurPatriot/ptz-cameras-control/wiki) for more information or contact with me on [Email](mailto:arthur.patriot@gmail.com) / [Telegram](https://t.me/ArthurPatriot).

## Features

* Momentary Movement (Default)
* Relative Movement
* To Home Movement
* To Preset Movement

> Other in Development :)

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License

[GPL-3.0](https://choosealicense.com/licenses/gpl-3.0/)
