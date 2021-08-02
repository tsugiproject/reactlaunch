
Tsugi React Tool Development Launcher
=====================================

When a Tsugi React tool is running in production, 
Tsugi's react support places the tool in a `dist` folder with an `index.php` file
that receives the launch and transfers launch data to the React application 
through the `_TSUGI` JavaScript variable.

So you *can* just re-deply over and over and launch the tool straight from `/tsugi/store`

    npm run build

But this is a slow process and does not allow for the amazing React under Node feature
where you edit a file and it auto-refreshes instantly.

This Tsugi React Development launcher makes it so you can edit and test a React tool
interactively.

Using this tool
---------------

Install this tool in a `mod` folder in yourt Tsugi instance.  Configure the tool to
point to the Node URL in Settings:

    http://localhost:9000/

And then you shoul dbe able to launch to the tool - and when you change the tool
it will auto-refresh.
