# Embed React Build in Wordpress

It is a plugin that allows you to integrate your ReactJS builds into wordpress.

This plugin reads the `asset-manifest.json` file in your ReactJS build and includes it in wordpress and allows you to run your application anywhere in wordpress.

## Prerequisites

1. A [WordPress](https://wordpress.org/support/article/how-to-install-wordpress/) (5.4 or later).
2. A ReactJS Build created with the [Create React App](https://create-react-app.dev/) 3.2.0 version or higher.
3. The `PUBLIC_URL` is defined in the `.env` file. For example: https://github.com/nurullah/react-default/blob/master/.env

## Usage

You can run your application embedded in wordpress by typing the following shortcode in the Wordpress text editor.

```
[embed_react_build 
  application_id="root" 
  url="https://react-default.netlify.app"]
```

## Shortcode Parameters

| Name | Description | Default | Optional? |
| :--- | :---        | :---:   | :---:     |
| `application_id` | The name of the container where the React application is mounted. | `root` | |
| `url` | The URL address of the React Build. | | |
| `staging_url` | The URL address of the React Staging Build. Once defined, you can access the staging build by typing `?test=true` at the end of the url. | | yes |

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[GPLv3](https://www.gnu.org/licenses/gpl-3.0.html)
