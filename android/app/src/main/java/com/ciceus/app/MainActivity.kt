package com.ciceus.app

import android.annotation.SuppressLint
import android.content.ActivityNotFoundException
import android.content.Intent
import android.graphics.Bitmap
import android.graphics.Color
import android.net.Uri
import android.os.Bundle
import android.view.View
import android.webkit.CookieManager
import android.webkit.ValueCallback
import android.webkit.WebChromeClient
import android.webkit.WebResourceError
import android.webkit.WebResourceRequest
import android.webkit.WebSettings
import android.webkit.WebView
import android.webkit.WebViewClient
import android.widget.Button
import android.widget.ProgressBar
import androidx.activity.OnBackPressedCallback
import androidx.activity.SystemBarStyle
import androidx.activity.enableEdgeToEdge
import androidx.activity.result.contract.ActivityResultContracts
import androidx.appcompat.app.AppCompatActivity
import androidx.core.view.ViewCompat
import androidx.core.view.WindowInsetsCompat

/**
 * O app e o site do Ciceus aberto numa WebView, sem a barra do navegador.
 * Tudo o que o usuario ve vem do servidor; aqui ficam so as pontes com o
 * Android: botao voltar, envio de arquivos, links externos, falta de
 * internet e o cookie de sessao.
 */
class MainActivity : AppCompatActivity() {

    private lateinit var webView: WebView
    private lateinit var carregando: ProgressBar
    private lateinit var semConexao: View

    /* o site pede um arquivo (botao de imagem do editor de notas) e a
       resposta chega depois, quando o usuario escolhe no seletor do android */
    private var callbackArquivo: ValueCallback<Array<Uri>>? = null

    private val seletorDeArquivo =
        registerForActivityResult(ActivityResultContracts.StartActivityForResult()) { resultado ->
            val arquivos = WebChromeClient.FileChooserParams.parseResult(resultado.resultCode, resultado.data)
            // devolver null cancela; sem isso o botao do site para de responder
            callbackArquivo?.onReceiveValue(arquivos)
            callbackArquivo = null
        }

    override fun onCreate(savedInstanceState: Bundle?) {
        /* barras do sistema transparentes e com icones escuros, porque o fundo
           do site e claro. "light" fixo: com o celular no modo escuro os icones
           ficariam brancos sobre o creme e sumiriam */
        enableEdgeToEdge(
            statusBarStyle = SystemBarStyle.light(Color.TRANSPARENT, Color.TRANSPARENT),
            navigationBarStyle = SystemBarStyle.light(Color.TRANSPARENT, Color.TRANSPARENT)
        )
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

        webView = findViewById(R.id.webview)
        carregando = findViewById(R.id.carregando)
        semConexao = findViewById(R.id.sem_conexao)

        ajustarAsBordasDaTela()
        configurarWebView()
        configurarBotaoVoltar()

        findViewById<Button>(R.id.tentar_novamente).setOnClickListener {
            semConexao.visibility = View.GONE
            webView.reload()
        }

        // ao girar a tela a activity nao e recriada (configChanges no manifest),
        // mas se o android matar o app em segundo plano a pagina volta daqui
        if (savedInstanceState == null || webView.restoreState(savedInstanceState) == null) {
            webView.loadUrl(BuildConfig.URL_INICIAL)
        }
    }

    /* com o enableEdgeToEdge o app desenha atras da barra de status, da barra
       de navegacao e do teclado. o padding empurra a pagina para a area livre,
       senao a navbar do site ficaria embaixo do relogio e o editor embaixo do teclado */
    private fun ajustarAsBordasDaTela() {
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.raiz)) { raiz, insets ->
            val barras = insets.getInsets(WindowInsetsCompat.Type.systemBars() or WindowInsetsCompat.Type.ime())
            raiz.setPadding(barras.left, barras.top, barras.right, barras.bottom)
            WindowInsetsCompat.CONSUMED
        }
    }

    @SuppressLint("SetJavaScriptEnabled")
    private fun configurarWebView() {
        webView.settings.apply {
            javaScriptEnabled = true      // editor de notas, temporizador, menu...
            domStorageEnabled = true
            cacheMode = WebSettings.LOAD_DEFAULT
            mediaPlaybackRequiresUserGesture = true
            setSupportZoom(false)
            // o site pode saber que esta dentro do app (ex.: para esconder algo)
            userAgentString = "$userAgentString CiceusApp/${BuildConfig.VERSION_NAME}"
        }

        // o login do site e um cookie de sessao do PHP; a WebView precisa aceita-lo
        CookieManager.getInstance().setAcceptCookie(true)

        WebView.setWebContentsDebuggingEnabled(BuildConfig.DEBUG)

        webView.webViewClient = object : WebViewClient() {

            /* paginas do ciceus abrem dentro do app; qualquer outro endereco
               (links colados numa nota, youtube...) abre no navegador */
            override fun shouldOverrideUrlLoading(view: WebView, request: WebResourceRequest): Boolean {
                val endereco = request.url
                if (ehDoCiceus(endereco)) return false

                abrirForaDoApp(endereco)
                return true
            }

            override fun onPageStarted(view: WebView, url: String?, favicon: Bitmap?) {
                carregando.visibility = View.VISIBLE
            }

            override fun onPageFinished(view: WebView, url: String?) {
                carregando.visibility = View.GONE
                // grava o cookie em disco ja, e nao so quando o app fechar
                CookieManager.getInstance().flush()
            }

            /* so o erro da pagina principal mostra a tela de sem conexao;
               uma imagem ou fonte que falhou nao derruba a pagina inteira */
            override fun onReceivedError(view: WebView, request: WebResourceRequest, error: WebResourceError) {
                if (request.isForMainFrame) {
                    semConexao.visibility = View.VISIBLE
                }
            }
        }

        webView.webChromeClient = object : WebChromeClient() {

            override fun onProgressChanged(view: WebView, progresso: Int) {
                carregando.progress = progresso
            }

            /* <input type="file"> do site (ex.: inserir imagem na nota).
               sem isso, tocar no botao nao faz nada dentro da WebView */
            override fun onShowFileChooser(
                webView: WebView,
                callback: ValueCallback<Array<Uri>>,
                parametros: WebChromeClient.FileChooserParams
            ): Boolean {
                callbackArquivo?.onReceiveValue(null)
                callbackArquivo = callback

                return try {
                    seletorDeArquivo.launch(
                        Intent.createChooser(parametros.createIntent(), getString(R.string.escolher_arquivo))
                    )
                    true
                } catch (e: ActivityNotFoundException) {
                    callbackArquivo = null
                    false
                }
            }
        }
    }

    /* o voltar do android volta a pagina do site; so fecha o app
       quando nao ha mais para onde voltar */
    private fun configurarBotaoVoltar() {
        onBackPressedDispatcher.addCallback(this, object : OnBackPressedCallback(true) {
            override fun handleOnBackPressed() {
                if (webView.canGoBack()) {
                    webView.goBack()
                } else {
                    isEnabled = false
                    onBackPressedDispatcher.onBackPressed()
                }
            }
        })
    }

    private fun ehDoCiceus(endereco: Uri): Boolean {
        val host = endereco.host ?: return false
        return host == BuildConfig.DOMINIO || host.endsWith("." + BuildConfig.DOMINIO)
    }

    private fun abrirForaDoApp(endereco: Uri) {
        try {
            startActivity(Intent(Intent.ACTION_VIEW, endereco))
        } catch (e: ActivityNotFoundException) {
            // nenhum app sabe abrir esse endereco: ignora o toque
        }
    }

    override fun onSaveInstanceState(outState: Bundle) {
        super.onSaveInstanceState(outState)
        webView.saveState(outState)
    }

    override fun onPause() {
        super.onPause()
        CookieManager.getInstance().flush()
        webView.onPause()
    }

    override fun onResume() {
        super.onResume()
        webView.onResume()
    }

    override fun onDestroy() {
        webView.destroy()
        super.onDestroy()
    }
}
