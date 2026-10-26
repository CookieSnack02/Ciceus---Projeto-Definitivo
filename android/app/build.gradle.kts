plugins {
    alias(libs.plugins.android.application)
    alias(libs.plugins.kotlin.android)
}

android {
    namespace = "com.ciceus.app"
    compileSdk = 35

    defaultConfig {
        applicationId = "com.ciceus.app"
        // android 8.0+: permite usar so o icone adaptativo (vetor), sem PNGs por densidade
        minSdk = 26
        targetSdk = 35
        versionCode = 1
        versionName = "1.0"

        // endereco que o app abre. trocar aqui para apontar para outro servidor
        buildConfigField("String", "URL_INICIAL", "\"https://www.ciceus.com/\"")
        buildConfigField("String", "DOMINIO", "\"ciceus.com\"")
    }

    buildTypes {
        release {
            isMinifyEnabled = true
            isShrinkResources = true
            proguardFiles(
                getDefaultProguardFile("proguard-android-optimize.txt"),
                "proguard-rules.pro"
            )
        }
    }

    compileOptions {
        sourceCompatibility = JavaVersion.VERSION_17
        targetCompatibility = JavaVersion.VERSION_17
    }

    kotlinOptions {
        jvmTarget = "17"
    }

    buildFeatures {
        buildConfig = true
    }
}

dependencies {
    implementation(libs.androidx.core.ktx)
    implementation(libs.androidx.appcompat)
    implementation(libs.androidx.activity)
}
