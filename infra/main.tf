terraform {
  required_providers {
    koyeb = {
      source  = "koyeb/koyeb"
      version = "~> 0.1.0"
    }
  }
}

# O token será lido automaticamente da variável de ambiente KOYEB_TOKEN
provider "koyeb" {}

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

  instance_type = "micro-1x"
  regions       = ["fra"] # Frankfurt

  docker {
    image = "${var.docker_image_name}:${var.docker_image_tag}"
  }
}
