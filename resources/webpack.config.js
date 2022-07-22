// * Plugins
const CopyPlugin = require("copy-webpack-plugin");
const HtmlMinimizerPlugin = require("html-minimizer-webpack-plugin");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const RemoveEmptyScriptsPlugin = require("webpack-remove-empty-scripts");

const path = require("path");

const SCRIPT_LIBS = [
	"./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js",
];

const STYLE_LIBS = [
	"./node_modules/bootstrap/dist/css/bootstrap.min.css",
	"./node_modules/bootstrap-icons/font/bootstrap-icons.css",
	"./node_modules/@sweetalert2/theme-bootstrap-4/bootstrap-4.min.css",
];

const STYLE_CUSTOM = [
	"./css/clearfix.css",
	"./css/variables.css",
	"./css/style.css",
];

module.exports = {
	entry: {
		// * Arquivos js
		"script-libs": SCRIPT_LIBS,
		"script-admin-panel": "./js/admin-panel.js",
		"script-home": "./js/home.js",
		"script-login": "./js/login.js",
		"script-quiz": "./js/quiz.js",
		// * Arquivos css
		"style-libs": STYLE_LIBS,
		"style-admin-panel": "./css/admin-panel.css",
		"style-home": "./css/home.css",
		"style-login": "./css/login.css",
		"style-quiz": "./css/quiz.css",
		"style-custom": STYLE_CUSTOM,
	},
	output: {
		path: path.resolve(__dirname, "../public/dist/"),
		filename: "[name].min.js",
	},
	module: {
		rules: [
			{
				test: /\.js$/i,
				exclude: /node_modules/,
				use: ["babel-loader"],
			},
			{
				test: /\.css$/i,
				use: [MiniCssExtractPlugin.loader, "css-loader"],
			},
			{
				test: /\.html$/i,
				type: "asset/resource",
			},
		],
	},
	plugins: [
		new RemoveEmptyScriptsPlugin(),
		new CopyPlugin({
			patterns: [
				{
					context: path.resolve(__dirname, ""),
					from: "./pages/admin-panel.html",
				},
				{
					context: path.resolve(__dirname, ""),
					from: "./pages/home.html",
				},
				{
					context: path.resolve(__dirname, ""),
					from: "./pages/login.html",
				},
				{
					context: path.resolve(__dirname, ""),
					from: "./pages/quiz.html",
				},
			],
		}),
		new MiniCssExtractPlugin({
			filename: "[name].min.css",
		}),
	],
	optimization: {
		minimizer: ["...", new CssMinimizerPlugin(), new HtmlMinimizerPlugin()],
	},
};
