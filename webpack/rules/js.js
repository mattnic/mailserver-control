module.exports = {
  test    : /\.(js)$/,
  exclude : /(node_modules|public|build|dist\/)/,
  use     : ['babel-loader'],
};
