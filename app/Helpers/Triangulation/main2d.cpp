/*

Triangulation helper

Because php is too slow.

This programs receives the position of each fixed point and length to the required position.
It then compute the most likely position and print on stdout. 

INPUT: n d (P11, P12, ..., P1d, t1, l1) ... (Pn1, Pn2, ..., Pnd, tn, ln) (p1, p2, ..., pd starting coordinate)
OUTPUT: (x1, x2, ..., xd) the most likely point
*/

#include <cmath>
#include <iostream>
#include <vector>

const double pi = acos(-1);
const double GAP = 0.001;

typedef std::vector<double> point;

class Location {
	public:
		point position;
		int t;
		double length;
		double coef, rem_const;


		double gradience(point& q, int idx) const {
			return rem_const * (q[idx] - position[idx]);
		}

		Location(int d) : position(d) {}
};

double calcFitness(point P, std::vector<Location> &fixed) {
	// D = sum( (dx^2 + dy^2 + dz^2 - l^2) ^ 2 )
	double ans = 0.0;
	for (auto &loc : fixed) {
		double val = -pow(loc.length, 2);
		for (int i = 0 ; i < (int)P.size() ; ++i) {
			val += pow(P[i] - loc.position[i], 2);
		}
		ans += abs(val);
	}

	return ans;
}

int main(int argc, char* argv[]) {

	if (argc < 3) {
		std::cerr << "read instruction in the source code";
	}

	int argv_cnt = 1;

	const int n = atoi(argv[argv_cnt++]);
	const int d = atoi(argv[argv_cnt++]);

	if (d != 3) {
		return 0;
	}

	// parse all input
	std::vector<Location> location(n, Location(d));
	for (auto& loc : location) {
		for (double &x : loc.position) {
			x = atof(argv[argv_cnt++]);
		}
		loc.t = atoi(argv[argv_cnt++]);
		loc.length = atof(argv[argv_cnt++]);
	}

	point pos(d);
	for (double &x : pos) {
		x = atof(argv[argv_cnt++]);
	}

	// check for parsing error
	// for (auto& loc : location) {
	// 	for (double &x : loc.position) {
	// 		std::cerr << x << " ";
	// 	}
	// 	std::cerr << loc.t << " " << loc.length << std::endl;
	// }

	double ans = -1.0, ax, ay;
	for (auto &loc : location) {
		for (double ang = 0 ; ang < 2 * pi ; ang += GAP) {
			const double x = loc.position[0] + cos(ang) * loc.length;
			const double y = loc.position[1] + sin(ang) * loc.length;

			if (x < 0 or y < 0) continue;
			
			double res = calcFitness({x, y, 0}, location);
			if (res < ans or ans < 0.0) {
				ans = res;
				ax = x, ay = y;
			}
		}
	}

	pos = {ax, ay, 0};
	std::cout << pos[0] << " " << pos[1] << " " << 0 << std::endl;

	// std::cerr << "###########" << std::endl;
	// double D = 0;
	// for (auto& loc : location) {
	// 	double len = 0.0;
	// 	for (int i = 0 ; i < d ; ++i) {
	// 		std::cerr << loc.position[i] << " ";
	// 		len += pow(loc.position[i] - pos[i], 2);
	// 	}
	// 	std::cerr << loc.t << " " << loc.length << " # " << sqrt(len) << std::endl;
	// 	D += abs(len - pow(loc.length, 2));
	// }

	// std::cerr << D << std::endl;
	// std::cerr << ans << std::endl;

	return 0;
}