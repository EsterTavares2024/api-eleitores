terraform {
  required_providers {
    koyeb = {
      source  = "koyeb/koyeb"
      version = "~> 0.1.0"
    }
  }
}

provider "koyeb" {
  token = var.koyeb_token != "" ? var.koyeb_token : (try(env.KOYEB_TOKEN, ""))
}

resource "koyeb_service" "eleitor" {
  app_name = "eleitor-projeto"
  name     = "web"

  routes {
    path = "/"
  }

  ports {
    port     = 80
    protocol = "HTTP"
  }

  instance_type = "micro-1x" # ou altere conforme necessário
  regions       = ["fra"]    # Frankfurt, altere se preferir outro

  docker {
    image = "${var.docker_image_name}:${var.docker_image_tag}"
  }
}
