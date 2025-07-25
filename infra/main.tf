terraform {
  required_providers {
    koyeb = {
      source  = "koyeb/koyeb"
      version = "~> 0.1.0"
    }
  }
}

provider "koyeb" {}

resource "koyeb_service" "eleitor" {
  app_name = "eleitor-projeto"
  name     = "web"
  regions  = ["fra"] # Frankfurt


  definition {
    name = "web"

    docker {
      image = "${var.docker_image_name}:${var.docker_image_tag}"
    }

    ports {
      port     = 80
      protocol = "HTTP"
    }

    routes {
      path = "/"
      port = 80
    }

    instance_types {
      type = "micro-1x"
    }

    scalings {
      min = 1
      max = 1
    }
  }
}
