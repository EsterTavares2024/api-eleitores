terraform {
  required_providers {
    koyeb = {
      source  = "koyeb/koyeb"
      version = "~> 0.1.4"
    }
  }
}

provider "koyeb" {
  token = var.koyeb_token
}

resource "koyeb_app" "app" {
  name = var.service_name
}

resource "koyeb_service" "service" {
  app_id = koyeb_app.app.id
  name   = "${var.service_name}-service"

  routes {
    path = "/"
  }

  docker {
    image = "${var.docker_image_name}:${var.docker_image_tag}"
    pull_credentials {
      dockerhub {
        username = var.docker_user
        password = var.docker_pass
      }
    }
  }

  regions = [var.region]

  ports {
    port     = 80
    protocol = "HTTP"
  }

  instance_type = "micro"
}
